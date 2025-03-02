<?php

namespace App\Http\Controllers;

use App\Models\ProtectedDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Inertia\Inertia;

class DocumentProtectionController extends Controller
{
    public function home()
    {
        return Inertia::render('Documents/Home');
    }

    public function index(Request $request)
    {
        // Si l'utilisateur vient d'une page externe, rediriger vers la page d'accueil
        if (!$request->hasHeader('referer') || !str_contains($request->header('referer'), config('app.url'))) {
            return redirect()->route('documents.home');
        }
        
        return Inertia::render('Documents/Protect', [
            'documents' => auth()->user()->protectedDocuments
        ]);
    }

    public function protect(Request $request)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'watermark_text' => 'required|string|max:255',
            'purpose' => 'required|string|max:255',
        ]);

        $file = $request->file('document');
        $filename = time() . '_' . $file->getClientOriginalName();
        
        // Si c'est une image
        if (in_array($file->getMimeType(), ['image/jpeg', 'image/png', 'image/jpg'])) {
            $image = Image::make($file);
            
            // Ajout du filigrane
            $image->text($request->watermark_text, $image->width() / 2, $image->height() / 2, function($font) {
                $font->file(public_path('fonts/OpenSans-Regular.ttf'));
                $font->size(40);
                $font->color(array(255, 255, 255, 0.5));
                $font->align('center');
                $font->valign('middle');
                $font->angle(45);
            });

            // Sauvegarde de l'image
            Storage::disk('protected_docs')->put($filename, (string) $image->encode());
        }
        // Si c'est un PDF
        else {
            // Stockage temporaire du PDF - la version complète avec filigrane sera implémentée plus tard
            // Dans une future version, nous utiliserons une bibliothèque comme FPDF ou TCPDF
            Storage::disk('protected_docs')->putFileAs('', $file, $filename);
        }

        // Création de l'enregistrement
        ProtectedDocument::create([
            'user_id' => auth()->id(),
            'filename' => $filename,
            'original_name' => $file->getClientOriginalName(),
            'purpose' => $request->purpose,
            'watermark_text' => $request->watermark_text,
        ]);

        return redirect()->back()->with('success', 'Votre document a été protégé avec succès. Vous pouvez maintenant le télécharger depuis la liste ci-dessous.');
    }

    public function download(ProtectedDocument $document)
    {
        // Vérifier que l'utilisateur est autorisé à télécharger ce document
        if ($document->user_id !== auth()->id()) {
            abort(403, 'Vous n\'êtes pas autorisé à accéder à ce document protégé.');
        }

        return Storage::disk('protected_docs')->download($document->filename, $document->original_name);
    }

    public function destroy(ProtectedDocument $document)
    {
        // Vérifier que l'utilisateur est autorisé à supprimer ce document
        if ($document->user_id !== auth()->id()) {
            abort(403, 'Vous n\'êtes pas autorisé à supprimer ce document protégé.');
        }

        // Supprimer le fichier
        Storage::disk('protected_docs')->delete($document->filename);
        
        // Supprimer l'enregistrement
        $document->delete();

        return redirect()->back()->with('success', 'Le document a été supprimé avec succès de votre bibliothèque.');
    }
}
