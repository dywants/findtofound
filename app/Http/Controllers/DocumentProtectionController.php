<?php

namespace App\Http\Controllers;

use App\Models\ProtectedDocument;
use App\Services\DocumentProtectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class DocumentProtectionController extends Controller
{
    protected DocumentProtectionService $documentService;

    /**
     * Constructor avec injection de dépendance
     */
    public function __construct(DocumentProtectionService $documentService)
    {
        $this->documentService = $documentService;
    }

    /**
     * Affiche la page d'accueil
     */
    public function home()
    {
        return Inertia::render('Documents/Home');
    }

    /**
     * Affiche la page de protection de documents
     */
    public function index(Request $request)
    {
        // Sécurité contre les accès directs à cette route
        // Remarque: cette vérification peut être déplacée dans un middleware personnalisé
        if (!$request->hasHeader('referer') || !str_contains($request->header('referer'), config('app.url'))) {
            return redirect()->route('documents.home');
        }

        // Récupérer les documents protégés de l'utilisateur
        $documents = auth()->user()->protectedDocuments()
            ->latest()
            ->get()
            ->map(function ($document) {
                // Ajouter des métadonnées utiles pour l'interface
                return array_merge($document->toArray(), [
                    'download_url' => route('documents.download', $document->id)
                ]);
            });

        return Inertia::render('Documents/Protect', [
            'documents' => $documents
        ]);
    }

    /**
     * Protége un document avec filigrane
     */
    public function protect(Request $request)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png,gif,webp|max:10240',
            'watermark_text' => 'required|string|max:255',
            'purpose' => 'required|string|max:255',
            // Nouveaux champs pour les options de filigranage
            'opacity' => 'nullable|numeric|min:0.1|max:1',
            'rotation' => 'nullable|numeric|min:0|max:360',
            'fontSize' => 'nullable|string',
            'repetition' => 'nullable|boolean',
            'position' => 'nullable|string|in:center,top-left,top-right,bottom-left,bottom-right',
        ]);

        try {
            // Extraire les options avancées si elles sont présentes
            $options = [];
            foreach (['opacity', 'rotation', 'fontSize', 'repetition', 'position'] as $option) {
                if ($request->has($option) && $request[$option] !== null) {
                    $options[$option] = $request[$option];
                }
            }

            // Appliquer le filigrane via le service
            $filename = $this->documentService->applyWatermark(
                $request->file('document'),
                $request->watermark_text,
                $options
            );

            // Pour debug - vérifier l'extension du fichier généré
            Log::info('Fichier protégé généré', [
                'filename' => $filename,
                'extension' => pathinfo($filename, PATHINFO_EXTENSION)
            ]);

            // Créer l'enregistrement en base de données avec les options
            $document = $this->documentService->createDocumentRecord(
                auth()->id(),
                $filename,
                $request->file('document')->getClientOriginalName(),
                $request->purpose,
                $request->watermark_text,
                $options
            );

            // Pour debug - vérifier les noms enregistrés en base
            Log::info('Document enregistré en base de données', [
                'id' => $document->id,
                'filename' => $document->filename,
                'original_name' => $document->original_name
            ]);

            return redirect()->route('documents.protect')
                ->with('success', 'Votre document a été protégé avec succès. Vous pouvez maintenant le télécharger depuis la liste ci-dessous.');
        } catch (\Exception $e) {
            // Vérifier si c'est l'erreur de compression PDF non supportée (code 1001)
            if ($e->getCode() === 1001) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors([
                        'document' => 'Ce PDF utilise une technique de compression avancée qui n\'est pas supportée. Veuillez utiliser un PDF standard ou contacter le support pour plus d\'informations.'
                    ]);
            }
            // Journaliser l'erreur pour le debugging
            Log::error('Erreur lors de la protection du document', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withInput()
                ->withErrors([
                    'document' => 'Une erreur est survenue lors de la protection du document. Veuillez réessayer ou contacter le support si le problème persiste.'
                ]);
        }
    }

    /**
     * Télécharger un document protégé
     */
    public function download(ProtectedDocument $document)
    {
        // Vérifier que l'utilisateur est autorisé à télécharger ce document
        if ($document->user_id !== auth()->id()) {
            abort(403, 'Vous n\'êtes pas autorisé à accéder à ce document protégé.');
        }

        // Vérifier que le fichier existe
        if (!Storage::disk('protected_docs')->exists($document->filename)) {
            abort(404, 'Le fichier demandé n\'existe plus sur le serveur.');
        }

        // S'assurer que le nom de téléchargement a l'extension PDF
        $downloadName = $document->original_name;
        if (!str_ends_with(strtolower($downloadName), '.pdf')) {
            $downloadName = pathinfo($downloadName, PATHINFO_FILENAME) . '.pdf';
        }

        return Storage::disk('protected_docs')->download(
            $document->filename,
            $document->original_name
        );
    }

    /**
     * Supprimer un document protégé
     */
    public function destroy(ProtectedDocument $document)
    {
        // Vérifier que l'utilisateur est autorisé à supprimer ce document
        if ($document->user_id !== auth()->id()) {
            abort(403, 'Vous n\'êtes pas autorisé à supprimer ce document protégé.');
        }

        try {
            // Supprimer le fichier
            if (Storage::disk('protected_docs')->exists($document->filename)) {
                Storage::disk('protected_docs')->delete($document->filename);
            }

            // Supprimer l'enregistrement
            $document->delete();

            return redirect()->back()
                ->with('success', 'Le document a été supprimé avec succès de votre bibliothèque.');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression du document', [
                'document_id' => $document->id,
                'error' => $e->getMessage()
            ]);

            return redirect()->back()
                ->withErrors([
                    'delete' => 'Une erreur est survenue lors de la suppression du document.'
                ]);
        }
    }
}
