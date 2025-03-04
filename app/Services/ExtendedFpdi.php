<?php

namespace App\Services;

use setasign\Fpdi\Fpdi;

/**
 * Extension de la classe FPDI avec des fonctionnalités pour le filigranage
 */
class ExtendedFpdi extends Fpdi
{
    /**
     * États graphiques étendus pour la transparence
     */
    protected $extGStates = array();

    /**
     * Angle de rotation actuel
     */
    protected $angle = 0;

    /**
     * Surcharge la méthode _putresources pour inclure les états graphiques
     */
    function _putresources()
    {
        $this->_putextgstates();
        parent::_putresources();
    }

    /**
     * Écrit les états graphiques pour la transparence dans le document PDF
     */
    function _putextgstates()
    {
        // Ne rien faire si pas d'états graphiques définis
        if (count($this->extGStates) == 0) {
            return;
        }

        // Créer les objets d'état graphique dans le PDF
        foreach($this->extGStates as $k => $extgstate)
        {
            $this->_newobj();
            $this->extGStates[$k]['n'] = $this->n;
            $this->_put('<</Type /ExtGState');

            foreach($extgstate as $key => $value)
            {
                if($key != 'n')
                {
                    $this->_put('/'.$key.' '.$value);
                }
            }

            $this->_put('>>');
            $this->_put('endobj');
        }
    }

    /**
     * Ajoute les références des objets graphiques dans le catalogue du PDF
     */
    function _putresourcedict()
    {
        parent::_putresourcedict();

        // Ajouter les références aux objets d'état graphique s'ils existent
        if (count($this->extGStates) > 0) {
            $this->_put('/ExtGState <<');
            foreach($this->extGStates as $k => $extgstate) {
                // Vérifier que le numéro d'objet est défini
                if (isset($extgstate['n'])) {
                    $this->_put('/GS'.$k.' '.$extgstate['n'].' 0 R');
                }
            }
            $this->_put('>>');
        }
    }

    /**
     * Fait pivoter le contenu autour d'un point spécifié
     *
     * @param float $angle Angle de rotation (0-360)
     * @param float $x Point X autour duquel effectuer la rotation
     * @param float $y Point Y autour duquel effectuer la rotation
     */
    public function Rotate($angle, $x = -1, $y = -1)
    {
        // Si les coordonnées ne sont pas spécifiées, utiliser la position courante
        if ($x == -1) {
            $x = $this->w / 2;
        }
        if ($y == -1) {
            $y = $this->h / 2;
        }

        // Ne rien faire si l'angle est le même
        if ($this->angle == $angle) {
            return;
        }

        // Terminer la transformation précédente
        if ($this->angle != 0) {
            $this->_out('Q');
        }

        // Mémoriser le nouvel angle
        $this->angle = $angle;

        // Appliquer la rotation
        if ($angle != 0) {
            $angle *= M_PI / 180;
            $c = cos($angle);
            $s = sin($angle);

            // Sauvegarder l'état courant
            $this->_out('q');

            // Effectuer la transformation
            $tx = $x;
            $ty = $this->h - $y;
            $this->_out(sprintf('1 0 0 1 %.2F %.2F cm', $tx, $ty));
            $this->_out(sprintf('%.5F %.5F %.5F %.5F 0 0 cm', $c, $s, -$s, $c));
            $this->_out(sprintf('1 0 0 1 %.2F %.2F cm', -$tx, -$ty));
        }
    }

    /**
     * Réinitialise la rotation de manière sécurisée
     */
    public function _endRotation()
    {
        if ($this->angle != 0) {
            // Rétablir l'état graphique normal
            $this->_out('Q');
            $this->angle = 0;
        }
    }

    /**
     * Définit le niveau de transparence et le mode de fusion
     *
     * @param float $alpha Valeur de transparence (0-1)
     * @param string $blendMode Mode de fusion (optionnel)
     */
    public function SetAlpha($alpha, $blendMode='Normal')
    {
        // Liste des modes de fusion disponibles
        $blendModes = array(
            'Normal', 'Multiply', 'Screen', 'Overlay', 'Darken', 'Lighten', 'ColorDodge', 'ColorBurn',
            'HardLight', 'SoftLight', 'Difference', 'Exclusion', 'Hue', 'Saturation', 'Color', 'Luminosity'
        );

        if(!in_array($blendMode, $blendModes)) {
            $blendMode = 'Normal';
        }

        // Créer un identifiant unique pour cet état graphique
        $gs = md5($alpha.$blendMode);

        // Vérifier si cet état graphique existe déjà
        if(!isset($this->extGStates[$gs])) {
            // Créer un nouvel état graphique
            $this->extGStates[$gs] = array(
                'ca' => $alpha,       // Opacité pour le contenu non-stroke
                'CA' => $alpha,       // Opacité pour le contenu stroke
                'BM' => '/'.$blendMode, // Mode de fusion
                'SMask' => 'None',    // Pas de masque
                'AIS' => 'false',     // Antialiasing activé
                'Type' => 'ExtGState' // Type de l'objet
            );
        }

        // Les états graphiques ne sont pas encore finalisés lors de l'exécution de cette méthode
        $this->_out('/GS'.$gs.' gs');
    }

    /**
     * Applique un filigrane de style "COPIE CONTROLÉE" répété sur tout le document
     *
     * @param string $text Texte du filigrane
     * @param array $options Options du filigrane
     */
    public function AddWatermark($text, $options = [])
    {
        // Options par défaut
        $defaults = [
            'opacity' => 0.3,          // Opacité par défaut
            'rotation' => 45,          // Angle de rotation en degrés
            'fontSize' => 'auto',      // 'auto' ou taille spécifique en points
            'fontStyle' => 'B',        // Style de police (B = gras)
            'textColor' => [150, 150, 150], // Gris par défaut
            'position' => 'repeat',    // Position par défaut: répéter sur toute la page
            'spacing' => 100           // Espacement entre les répétitions
        ];

        // Fusion des options par défaut avec les options fournies
        $options = array_merge($defaults, $options);

        // Dimensions de la page
        $pageWidth = $this->GetPageWidth();
        $pageHeight = $this->GetPageHeight();

        // Calculer la taille de police - adaptée à la page
        if ($options['fontSize'] === 'auto') {
            // Taille proportionnelle au document, similaire à "COPIE CONTROLÉE"
            $fontSize = min(24, max(14, min($pageWidth, $pageHeight) / 20));
        } else {
            $fontSize = intval($options['fontSize']);
        }

        // Définir la police et sa taille
        $this->SetFont('Helvetica', $options['fontStyle'], $fontSize);

        // Définir la couleur
        $this->SetTextColor(...$options['textColor']);

        // Définir la transparence
        $this->SetAlpha($options['opacity']);

        // Sauvegarder l'état graphique
        $this->_out('q');

        // Espacement entre les répétitions
        $spacing = $options['spacing'];

        if ($options['position'] == 'repeat') {
            // Calculer combien de fois répéter horizontalement et verticalement
            $numHorizontal = ceil($pageWidth / $spacing) + 1;
            $numVertical = ceil($pageHeight / $spacing) + 1;

            // Calculer l'offset pour centrer la grille
            $offsetX = ($pageWidth - ($numHorizontal - 1) * $spacing) / 2;
            $offsetY = ($pageHeight - ($numVertical - 1) * $spacing) / 2;

            // Appliquer des filigranes en grille
            for ($i = 0; $i < $numHorizontal; $i++) {
                for ($j = 0; $j < $numVertical; $j++) {
                    $x = $offsetX + $i * $spacing;
                    $y = $offsetY + $j * $spacing;

                    // Sauvegarder l'état avant rotation
                    $this->_out('q');

                    // Rotation autour du point
                    $this->Rotate($options['rotation'], $x, $y);

                    // Calculer dimensions du texte
                    $textWidth = $this->GetStringWidth($text);

                    // Écrire le texte
                    $this->Text($x - $textWidth/2, $y, $text);

                    // Restaurer l'état après rotation
                    $this->_endRotation();
                    $this->_out('Q');
                }
            }
        } else {
            // Position simple (ancienne méthode)
            switch ($options['position']) {
                case 'top':
                    $x = $pageWidth / 2;
                    $y = $pageHeight / 4;
                    break;
                case 'bottom':
                    $x = $pageWidth / 2;
                    $y = 3 * ($pageHeight / 4);
                    break;
                case 'left':
                    $x = $pageWidth / 4;
                    $y = $pageHeight / 2;
                    break;
                case 'right':
                    $x = 3 * ($pageWidth / 4);
                    $y = $pageHeight / 2;
                    break;
                case 'center':
                default:
                    $x = $pageWidth / 2;
                    $y = $pageHeight / 2;
                    break;
            }

            $this->Rotate($options['rotation'], $x, $y);
            $textWidth = $this->GetStringWidth($text);
            $this->Text($x - $textWidth/2, $y, $text);
            $this->_endRotation();
        }

        // Restaurer l'état graphique global
        $this->_out('Q');

        // Réinitialiser la transparence
        $this->SetAlpha(1.0);
    }
}
