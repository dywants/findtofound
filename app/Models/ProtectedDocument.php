<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProtectedDocument extends Model
{
    use HasFactory;

    /**
     * Les attributs assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'filename',
        'original_name',
        'purpose',
        'watermark_text',
        'watermark_options',
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'watermark_options' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Obtenir l'utilisateur propriétaire du document.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Récupérer une option de filigrane spécifique
     *
     * @param string $option Nom de l'option
     * @param mixed $default Valeur par défaut
     * @return mixed
     */
    public function getWatermarkOption(string $option, $default = null)
    {
        if (!$this->watermark_options) {
            return $default;
        }

        return $this->watermark_options[$option] ?? $default;
    }

    /**
     * Définir les options de filigrane
     *
     * @param array $options
     * @return void
     */
    public function setWatermarkOptions(array $options): void
    {
        $this->watermark_options = $options;
    }
}
