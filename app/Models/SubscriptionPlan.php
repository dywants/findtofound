<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubscriptionPlan extends Model
{
    use HasFactory;

    /**
     * Les attributs assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price_monthly',
        'price_yearly',
        'features',
        'is_active',
        'sort_order',
        'currency_id',
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price_monthly' => 'decimal:2',
        'price_yearly' => 'decimal:2',
        'features' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
    
    /**
     * Les attributs ajoutés au tableau de l'objet lors de la sérialisation.
     *
     * @var array
     */
    protected $appends = [
        'formatted_monthly_price',
        'formatted_yearly_price',
    ];

    /**
     * Les relations avec les abonnements utilisateurs.
     */
    public function userSubscriptions(): HasMany
    {
        return $this->hasMany(UserSubscription::class);
    }
    
    /**
     * La devise dans laquelle les prix sont stockés.
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Vérifie si le plan est gratuit.
     *
     * @return bool
     */
    public function isFree(): bool
    {
        return $this->price_monthly == 0 && $this->price_yearly == 0;
    }

    /**
     * Récupère une fonctionnalité spécifique du plan.
     *
     * @param string $key Clé de la fonctionnalité
     * @param mixed $default Valeur par défaut
     * @return mixed
     */
    public function getFeature(string $key, $default = null)
    {
        if (!$this->features) {
            return $default;
        }

        return $this->features[$key] ?? $default;
    }

    /**
     * Récupère le nombre de générations de documents autorisées par mois.
     *
     * @return int
     */
    public function getMonthlyGenerationLimit(): int
    {
        return $this->getFeature('monthly_generations', 0);
    }

    /**
     * Récupère la taille maximale de document autorisée en MB.
     *
     * @return int
     */
    public function getMaxDocumentSize(): int
    {
        return $this->getFeature('max_document_size', 0);
    }

    /**
     * Récupère les types de documents supportés.
     *
     * @return array
     */
    public function getSupportedDocumentTypes(): array
    {
        return $this->getFeature('document_types', ['pdf']);
    }

    /**
     * Récupère la durée de stockage des documents en jours.
     *
     * @return int
     */
    public function getStorageDuration(): int
    {
        return $this->getFeature('storage_duration', 7);
    }

    /**
     * Récupère le nombre d'utilisateurs autorisés par compte.
     *
     * @return int
     */
    public function getUsersPerAccount(): int
    {
        return $this->getFeature('users_per_account', 1);
    }
    
    /**
     * Récupère le nombre de jours d'essai pour ce plan.
     *
     * @return int
     */
    public function getTrialDays(): int
    {
        return $this->getFeature('trial_days', 14);
    }
    
    /**
     * Obtient le prix mensuel dans la devise spécifiée.
     *
     * @param string|null $currencyCode Code de la devise (XAF, XOF, EUR, USD)
     * @return float Prix converti
     */
    public function getMonthlyPriceIn(?string $currencyCode = null): float
    {
        if (!$currencyCode) {
            return $this->price_monthly;
        }
        
        // Si le prix est déjà dans la devise demandée
        if ($this->currency && $this->currency->code === $currencyCode) {
            return $this->price_monthly;
        }
        
        // Sinon, convertir le prix
        return $this->convertPrice($this->price_monthly, $currencyCode);
    }
    
    /**
     * Obtient le prix annuel dans la devise spécifiée.
     *
     * @param string|null $currencyCode Code de la devise (XAF, XOF, EUR, USD)
     * @return float Prix converti
     */
    public function getYearlyPriceIn(?string $currencyCode = null): float
    {
        if (!$currencyCode) {
            return $this->price_yearly;
        }
        
        // Si le prix est déjà dans la devise demandée
        if ($this->currency && $this->currency->code === $currencyCode) {
            return $this->price_yearly;
        }
        
        // Sinon, convertir le prix
        return $this->convertPrice($this->price_yearly, $currencyCode);
    }
    
    /**
     * Convertit un prix de la devise du plan vers une autre devise.
     *
     * @param float $amount Montant à convertir
     * @param string $toCurrencyCode Code de la devise cible
     * @return float Montant converti
     */
    protected function convertPrice(float $amount, string $toCurrencyCode): float
    {
        // Récupérer les devises source et cible
        $fromCurrency = $this->currency ?? Currency::where('code', 'XAF')->first();
        $toCurrency = Currency::where('code', $toCurrencyCode)->first();
        
        if (!$fromCurrency || !$toCurrency) {
            return $amount; // Retourner le montant original si une devise n'est pas trouvée
        }
        
        // Convertir via les taux de change
        // Note: la formule suppose que le taux de change est relatif à une devise commune (ex: USD)
        $amountInBaseCurrency = $amount / $fromCurrency->exchange_rate;
        $convertedAmount = $amountInBaseCurrency * $toCurrency->exchange_rate;
        
        // Arrondir selon les conventions de la devise cible
        return round($convertedAmount, $toCurrency->decimal_places);
    }
    
    /**
     * Formate le prix mensuel dans la devise spécifiée.
     *
     * @param string|null $currencyCode Code de la devise
     * @param bool $includeSymbol Inclure le symbole de la devise
     * @return string Prix formaté
     */
    public function formattedMonthlyPrice(?string $currencyCode = null, bool $includeSymbol = true): string
    {
        $currencyCode = $currencyCode ?: ($this->currency->code ?? 'XAF');
        $currency = Currency::where('code', $currencyCode)->first();
        
        if (!$currency) {
            // Fallback au format simple si la devise n'est pas trouvée
            return number_format($this->price_monthly, 2);
        }
        
        return $currency->formatAmount($this->getMonthlyPriceIn($currencyCode), $includeSymbol);
    }
    
    /**
     * Formate le prix annuel dans la devise spécifiée.
     *
     * @param string|null $currencyCode Code de la devise
     * @param bool $includeSymbol Inclure le symbole de la devise
     * @return string Prix formaté
     */
    public function formattedYearlyPrice(?string $currencyCode = null, bool $includeSymbol = true): string
    {
        $currencyCode = $currencyCode ?: ($this->currency->code ?? 'XAF');
        $currency = Currency::where('code', $currencyCode)->first();
        
        if (!$currency) {
            // Fallback au format simple si la devise n'est pas trouvée
            return number_format($this->price_yearly, 2);
        }
        
        return $currency->formatAmount($this->getYearlyPriceIn($currencyCode), $includeSymbol);
    }
    
    /**
     * Accesseur pour le prix mensuel formaté
     *
     * @return string
     */
    public function getFormattedMonthlyPriceAttribute(): string
    {
        return $this->formattedMonthlyPrice();
    }
    
    /**
     * Accesseur pour le prix annuel formaté
     *
     * @return string
     */
    public function getFormattedYearlyPriceAttribute(): string
    {
        return $this->formattedYearlyPrice();
    }
    
    /**
     * Obtenir le prix d'un plan dans une autre devise par objet Currency
     *
     * @param float $price Le prix à convertir
     * @param Currency $targetCurrency La devise cible
     * @return float Le prix converti
     */
    public function getPriceInCurrency(float $price, Currency $targetCurrency): float
    {
        // Si pas de devise source, utiliser la devise par défaut
        if (!$this->currency) {
            $sourceCurrency = Currency::getDefault() ?? Currency::where('code', 'XAF')->first();
        } else {
            $sourceCurrency = $this->currency;
        }
        
        // Si la devise est la même, retourner le prix tel quel
        if ($sourceCurrency->id === $targetCurrency->id) {
            return $price;
        }
        
        // Utiliser la méthode de conversion de la devise source
        return $sourceCurrency->convertTo($price, $targetCurrency);
    }
}
