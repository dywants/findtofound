<?php

namespace App\Services;

use App\Models\ProtectedDocument;
use App\Services\ExtendedFpdi;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Log;
use FPDF;

class DocumentProtectionService
{
    /**
     * Options de filigranage par défaut - version simple et fiable
     */
    protected array $defaultOptions = [
        'opacity' => 0.5,          // Opacité élevée pour visibilité maximale
        'rotation' => 45,          // Angle de rotation en degrés
        'fontSize' => 'auto',      // 'auto' ou taille spécifique en points
        'color' => [255, 0, 0],    // Rouge pur pour un contraste maximal
        'position' => 'center'     // Position centrale par défaut
    ];

    /**
     * Applique un filigrane sur un document (PDF ou image)
     *
     * @param UploadedFile $file Fichier uploadé
     * @param string $watermarkText Texte du filigrane
     * @param array $options Options de filigranage (facultatif)
     * @return string Nom du fichier généré (toujours avec extension .pdf)
     */
    public function applyWatermark(UploadedFile $file, string $watermarkText, array $options = []): string
    {
        // Fusion des options avec les valeurs par défaut
        $options = array_merge($this->defaultOptions, $options);

        // Déterminer le type de fichier
        $mimeType = $file->getMimeType();

        // Générer un nom unique pour le fichier de sortie (toujours PDF)
        $fileBaseName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $outputFilename = time() . '_' . $fileBaseName . '.pdf';

        // Traitement selon le type de fichier
        if (in_array($mimeType, ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'])) {
            // Pour les images, créer un PDF (sans filigrane d'abord)
            $tempPdfPath = $this->createPdfFromImage($file);

            // Appliquer le filigrane au PDF temporaire
            $this->applyWatermarkToPdf($tempPdfPath, $watermarkText, $outputFilename, $options, true);

            // Log de debug pour confirmer l'extension
            Log::info('Image convertie en PDF', [
                'input_file' => $file->getClientOriginalName(),
                'output_file' => $outputFilename,
                'mime_type' => $mimeType
            ]);
        }
        elseif ($mimeType === 'application/pdf') {
            // Pour les PDF, appliquer directement le filigrane
            $this->applyWatermarkToPdf($file, $watermarkText, $outputFilename, $options);
        }
        else {
            throw new \InvalidArgumentException("Type de fichier non supporté: {$mimeType}");
        }

        return $outputFilename;
    }

    /**
     * Crée un PDF à partir d'une image
     *
     * @param UploadedFile $file Image à convertir
     * @return string Chemin du fichier PDF temporaire créé
     * @throws \Exception Si la conversion échoue
     */
    protected function createPdfFromImage(UploadedFile $file): string
    {
        // Créer dossier temporaire si inexistant
        $tempPath = storage_path('app/temp');
        if (!file_exists($tempPath)) {
            mkdir($tempPath, 0755, true);
        }

        // Nom de fichier temporaire pour le PDF de sortie
        $tempPdfPath = $tempPath . '/' . uniqid() . '.pdf';

        try {
            // Obtenir l'extension du fichier
            $extension = $file->getClientOriginalExtension();

            // Créer un fichier image temporaire
            $tempImagePath = $tempPath . '/' . uniqid() . '.' . $extension;
            copy($file->getRealPath(), $tempImagePath);

            // Obtenir les dimensions de l'image
            list($width, $height) = getimagesize($tempImagePath);

            // Déterminer l'orientation
            $orientation = ($width > $height) ? 'L' : 'P';

            // Créer un nouveau PDF
            $pdf = new \FPDF($orientation);
            $pdf->AddPage();

            // Obtenir les dimensions de la page PDF
            $pageWidth = $pdf->GetPageWidth();
            $pageHeight = $pdf->GetPageHeight();

            // Calculer le ratio pour que l'image s'adapte à la page
            $scaleWidth = ($pageWidth - 20) / $width; // marge de 10mm de chaque côté
            $scaleHeight = ($pageHeight - 20) / $height; // marge de 10mm en haut et en bas
            $scale = min($scaleWidth, $scaleHeight);

            // Nouvelles dimensions
            $newWidth = $width * $scale;
            $newHeight = $height * $scale;

            // Coordonnées pour centrer l'image sur la page
            $x = ($pageWidth - $newWidth) / 2;
            $y = ($pageHeight - $newHeight) / 2;

            // Placer l'image dans le PDF
            $pdf->Image($tempImagePath, $x, $y, $newWidth, $newHeight);

            // Sauvegarder le PDF
            $pdf->Output('F', $tempPdfPath);

            // Nettoyer l'image temporaire
            if (file_exists($tempImagePath)) {
                unlink($tempImagePath);
            }

            // S'assurer que le PDF a été créé correctement
            if (!file_exists($tempPdfPath) || filesize($tempPdfPath) < 100) {
                throw new \Exception("Le PDF généré est invalide ou trop petit");
            }

            return $tempPdfPath;

        } catch (\Throwable $e) {
            Log::error('Erreur lors de la création du PDF à partir de l\'image: ' . $e->getMessage());

            // Nettoyer les fichiers temporaires
            if (isset($tempImagePath) && file_exists($tempImagePath)) {
                unlink($tempImagePath);
            }

            throw new \Exception("Impossible de convertir l'image en PDF: " . $e->getMessage());
        }
    }

    /**
     * Applique un filigrane sur un PDF
     *
     * @param string|UploadedFile $file Chemin du fichier PDF ou objet UploadedFile
     * @param string $watermarkText Texte du filigrane
     * @param string $outputFilename Nom du fichier de sortie
     * @param array $options Options de filigranage
     * @param bool $isTemporaryFile Si le fichier source est temporaire et doit être supprimé
     * @throws \Exception Si le PDF utilise une compression non supportée ou une autre erreur survient
     */
    protected function applyWatermarkToPdf($file, string $watermarkText, string $outputFilename, array $options, bool $isTemporaryFile = false): void
    {
        // Déterminer le chemin du fichier PDF d'entrée
        $inputPdfPath = '';
        $needsCleanup = false;

        if (is_string($file)) {
            // C'est déjà un chemin de fichier
            $inputPdfPath = $file;
            $needsCleanup = $isTemporaryFile;
        } else {
            // C'est un UploadedFile, créer un fichier temporaire
            $tempPath = storage_path('app/temp');
            if (!file_exists($tempPath)) {
                mkdir($tempPath, 0755, true);
            }

            $inputPdfPath = $tempPath . '/' . uniqid() . '.pdf';
            file_put_contents($inputPdfPath, file_get_contents($file->getRealPath()));
            $needsCleanup = true;
        }

        try {
            // Utiliser notre classe ExtendedFpdi pour ajouter le filigrane
            $pdf = new ExtendedFpdi();

            // Vérifier que le fichier existe
            if (!file_exists($inputPdfPath)) {
                throw new \Exception("Le fichier PDF source n'existe pas: " . $inputPdfPath);
            }

            // Obtenir le nombre de pages
            try {
                $pageCount = $pdf->setSourceFile($inputPdfPath);
            } catch (\Exception $e) {
                // Vérifier si c'est l'erreur de compression non supportée
                if (strpos($e->getMessage(), 'compression technique which is not supported') !== false) {
                    throw new \Exception("Ce PDF utilise une technique de compression avancée non supportée par le système.", 1001);
                }
                // Sinon, propager l'erreur originale
                throw $e;
            }

            if ($pageCount < 1) {
                throw new \Exception("Le PDF source ne contient aucune page");
            }

            // Configurer les options pour un filigrane style "COPIE CONTROLÉE"
            $watermarkOptions = [
                'opacity' => 0.35,
                'rotation' => 45,
                'fontSize' => 'auto',
                'fontStyle' => 'B',
                'textColor' => [150, 150, 150],
                'position' => 'repeat',
                'spacing' => 120
            ];

            // Appliquer les options personnalisées si disponibles
            if (isset($options['opacity'])) {
                $watermarkOptions['opacity'] = floatval($options['opacity']);
            }

            if (isset($options['rotation'])) {
                $watermarkOptions['rotation'] = intval($options['rotation']);
            }

            if (isset($options['color']) && is_array($options['color'])) {
                $watermarkOptions['textColor'] = $options['color'];
            }

            // Traiter chaque page
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                // Importer la page
                $templateId = $pdf->importPage($pageNo);

                // Obtenir les dimensions de la page
                $pageSize = $pdf->getTemplateSize($templateId);

                // Ajouter une page avec la même orientation et dimensions
                $pdf->AddPage(
                    $pageSize['width'] > $pageSize['height'] ? 'L' : 'P',
                    [$pageSize['width'], $pageSize['height']]
                );

                // Utiliser la page importée comme template
                $pdf->useTemplate($templateId, 0, 0, $pageSize['width'], $pageSize['height'], true);

                // Appliquer le filigrane
                $pdf->AddWatermark($watermarkText, $watermarkOptions);
            }

            // Générer le PDF et le sauvegarder
            $watermarkedPdfContent = $pdf->Output('S');

            // S'assurer que le contenu est valide
            if (strlen($watermarkedPdfContent) < 100) {
                throw new \Exception("Le PDF généré est invalide ou trop petit");
            }

            // Sauvegarder dans le stockage
            Storage::disk('protected_docs')->put($outputFilename, $watermarkedPdfContent);

            // Vérifier que le fichier a été créé
            if (!Storage::disk('protected_docs')->exists($outputFilename)) {
                throw new \Exception("Échec de la sauvegarde du PDF protégé");
            }

        } catch (\Throwable $e) {
            // Journaliser l'erreur
            Log::error('Erreur lors de l\'application du filigrane sur le PDF: ' . $e->getMessage());

            // Si c'est notre erreur de compression, propager une exception avec un code spécial
            if ($e->getCode() === 1001) {
                throw new \Exception("Ce PDF utilise une compression avancée non supportée. Veuillez utiliser un PDF standard.", 1001);
            }

            // Sinon, propager l'erreur générique
            throw new \Exception("Échec de l'application du filigrane: " . $e->getMessage());
        } finally {
            // Nettoyer le fichier temporaire si nécessaire
            if ($needsCleanup && file_exists($inputPdfPath)) {
                unlink($inputPdfPath);
            }
        }
    }

    /**
     * Crée un document protégé en base de données
     *
     * @param int $userId ID de l'utilisateur
     * @param string $filename Nom du fichier généré
     * @param string $originalName Nom original du fichier
     * @param string $purpose But de l'utilisation
     * @param string $watermarkText Texte du filigrane
     * @param array $options Options du filigrane
     * @return ProtectedDocument
     */
    public function createDocumentRecord(
        int $userId,
        string $filename,
        string $originalName,
        string $purpose,
        string $watermarkText,
        array $options = []
    ): ProtectedDocument
    {
        // S'assurer que le nom du fichier original a l'extension correcte pour le téléchargement
        // Si le fichier original n'était pas un PDF mais que nous l'avons converti,
        // modifions l'extension pour que l'utilisateur puisse l'ouvrir correctement
        $originalExt = pathinfo($originalName, PATHINFO_EXTENSION);
        $fileExt = pathinfo($filename, PATHINFO_EXTENSION);

        if (strtolower($originalExt) !== 'pdf' && strtolower($fileExt) === 'pdf') {
            // Si le fichier original n'était pas un PDF mais que notre fichier généré est un PDF,
            // changeons l'extension dans le nom original pour que le téléchargement soit correct
            $originalBaseName = pathinfo($originalName, PATHINFO_FILENAME);
            $originalName = $originalBaseName . '.pdf';

            // Log pour confirmer le changement d'extension
            Log::info('Extension de fichier original modifiée', [
                'avant' => $originalExt,
                'après' => 'pdf',
                'nouveau_nom' => $originalName
            ]);
        }

        return ProtectedDocument::create([
            'user_id' => $userId,
            'filename' => $filename, // Toujours avec extension .pdf
            'original_name' => $originalName, // Modifié avec extension .pdf si c'était une image
            'purpose' => $purpose,
            'watermark_text' => $watermarkText,
            'watermark_options' => $options,
        ]);
    }
}
