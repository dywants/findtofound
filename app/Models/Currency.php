<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Currency extends Model
{
    use HasFactory;

    /**
     * Les attributs assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'name',
        'symbol',
        'exchange_rate',
        'is_active',
        'is_default',
        'decimal_places',
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'exchange_rate' => 'decimal:6',
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'decimal_places' => 'integer',
    ];

    /**
     * Les plans d'abonnement dans cette devise.
     */
    public function subscriptionPlans(): HasMany
    {
        return $this->hasMany(SubscriptionPlan::class, 'currency_id');
    }

    /**
     * Formater un montant selon les conventions de cette devise.
     *
     * @param float $amount Le montant à formater
     * @param bool $includeSymbol Inclure le symbole de la devise
     * @return string
     */
    public function formatAmount(float $amount, bool $includeSymbol = true): string
    {
        $formattedAmount = number_format(
            $amount, 
            $this->decimal_places, 
            ',', // Séparateur décimal
            ' '  // Séparateur de milliers
        );

        if ($includeSymbol) {
            // Gérer les symboles pré/post selon la devise
            if (in_array($this->code, ['USD', 'EUR'])) {
                return $this->symbol . ' ' . $formattedAmount;
            } else {
                return $formattedAmount . ' ' . $this->symbol;
            }
        }

        return $formattedAmount;
    }

    /**
     * Récupère la devise par défaut.
     *
     * @return Currency|null
     */
    public static function getDefault()
    {
        return static::where('is_default', true)->first();
    }
    
    /**
     * Convertit un montant de cette devise vers une autre devise.
     *
     * @param float $amount Montant à convertir
     * @param Currency $toCurrency Devise cible
     * @return float Montant converti
     */
    public function convertTo(float $amount, Currency $toCurrency): float
    {
        // Si les devises sont identiques, pas de conversion nécessaire
        if ($this->id === $toCurrency->id) {
            return $amount;
        }
        
        // Convertir via l'EUR comme devise de base
        $amountInEur = $amount / $this->exchange_rate;
        $convertedAmount = $amountInEur * $toCurrency->exchange_rate;
        
        // Arrondir selon les conventions de la devise cible
        return round($convertedAmount, $toCurrency->decimal_places);
    }
}
