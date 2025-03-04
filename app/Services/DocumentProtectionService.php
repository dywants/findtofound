<?php

namespace App\Services;

use App\Models\ProtectedDocument;
use App\Services\ExtendedFpdi;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

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
     * @return string Nom du fichier généré
     */
    public function applyWatermark(UploadedFile $file, string $watermarkText, array $options = []): string
    {
        // Fusion des options avec les valeurs par défaut
        $options = array_merge($this->defaultOptions, $options);

        // Génération d'un nom de fichier unique
        $filename = time() . '_' . $file->getClientOriginalName();

        // Déterminer le type de fichier
        $mimeType = $file->getMimeType();

        // Traitement selon le type de fichier
        if (in_array($mimeType, ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'])) {
            $this->applyWatermarkToImage($file, $watermarkText, $filename, $options);
        } elseif ($mimeType === 'application/pdf') {
            $this->applyWatermarkToPdf($file, $watermarkText, $filename, $options);
        } else {
            throw new \InvalidArgumentException("Type de fichier non supporté: {$mimeType}");
        }

        return $filename;
    }

    /**
     * Applique un filigrane sur une image - méthode simple et fiable
     */
    protected function applyWatermarkToImage(UploadedFile $file, string $watermarkText, string $filename, array $options): void
    {
        // Chargement de l'image
        $image = Image::make($file);

        // Création d'un canvas transparent pour le filigrane
        $canvas = Image::canvas($image->width(), $image->height(), [255, 255, 255, 0]);

        // Calcul de la taille de police pour une visibilité maximale
        $fontSize = $options['fontSize'] === 'auto'
            ? max(72, min($image->width(), $image->height()) / 4) // Très grande taille
            : $options['fontSize'];

        // Convertir la couleur en RGBA avec l'opacité
        $rgba = array_merge($options['color'], [$options['opacity']]);

        // Ajouter un filigrane central très visible
        $canvas->text($watermarkText, $image->width() / 2, $image->height() / 2, function($font) use ($fontSize, $rgba, $options) {
            $font->file(public_path('fonts/OpenSans-Regular.ttf'));
            $font->size($fontSize);
            $font->color($rgba);
            $font->align('center');
            $font->valign('middle');
            $font->angle($options['rotation']);
        });

        // Fusionner le canvas avec l'image originale
        $image->insert($canvas, 'top-left', 0, 0);

        // Sauvegarder l'image
        Storage::disk('protected_docs')->put($filename, (string) $image->encode());
    }

    /**
     * Applique un filigrane sur un PDF - méthode style "COPIE CONTROLÉE"
     */
    protected function applyWatermarkToPdf(UploadedFile $file, string $watermarkText, string $filename, array $options): void
    {
        // Créer un emplacement temporaire pour le PDF original
        $tempPath = storage_path('app/temp');

        if (!file_exists($tempPath)) {
            mkdir($tempPath, 0755, true);
        }

        $originalPdfPath = $tempPath . '/' . uniqid() . '.pdf';
        file_put_contents($originalPdfPath, file_get_contents($file->getRealPath()));

        try {
            // Utiliser notre classe ExtendedFpdi simplifiée
            $pdf = new ExtendedFpdi();

            // Obtenir le nombre de pages
            $pageCount = $pdf->setSourceFile($originalPdfPath);

            // Configurer les options pour un filigrane style "COPIE CONTROLÉE"
            $watermarkOptions = [
                'opacity' => 0.35,                     // Opacité légère mais visible
                'rotation' => 45,                      // Angle de 45 degrés
                'fontSize' => 'auto',                  // Taille automatique
                'fontStyle' => 'B',                    // Gras pour meilleure visibilité
                'textColor' => [150, 150, 150],        // Gris pour ne pas obscurcir le contenu
                'position' => 'repeat',                // Répéter sur toute la page
                'spacing' => 120                       // Espacement entre les répétitions
            ];

            // Si une couleur spécifique est demandée, l'utiliser
            if (isset($options['color']) && is_array($options['color'])) {
                $watermarkOptions['textColor'] = $options['color'];
            }

            // Traiter chaque page
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                // Importer la page
                $templateId = $pdf->importPage($pageNo);

                // Obtenir les dimensions de la page
                $pageSize = $pdf->getTemplateSize($templateId);

                // Ajouter une page au PDF de sortie avec les mêmes dimensions que l'original
                $pdf->AddPage(
                    $pageSize['width'] > $pageSize['height'] ? 'L' : 'P',
                    [$pageSize['width'], $pageSize['height']]
                );

                // Utiliser la page importée comme template
                $pdf->useTemplate($templateId, 0, 0, $pageSize['width'], $pageSize['height'], true);

                // Appliquer le filigrane répété partout
                $pdf->AddWatermark($watermarkText, $watermarkOptions);
            }

            // Générer le PDF et le sauvegarder
            $protectedPdfContent = $pdf->Output('S');
            Storage::disk('protected_docs')->put($filename, $protectedPdfContent);

        } finally {
            // Supprimer le fichier temporaire
            if (file_exists($originalPdfPath)) {
                unlink($originalPdfPath);
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
        return ProtectedDocument::create([
            'user_id' => $userId,
            'filename' => $filename,
            'original_name' => $originalName,
            'purpose' => $purpose,
            'watermark_text' => $watermarkText,
            'watermark_options' => $options,
        ]);
    }
}
