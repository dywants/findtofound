<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class UsageTracking extends Model
{
    use HasFactory;

    /**
     * Les attributs assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'user_subscription_id',
        'feature_type', // 'document_generation', 'document_storage', etc.
        'count',
        'reset_at',
        'details',
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'count' => 'integer',
        'reset_at' => 'datetime',
        'details' => 'array',
    ];

    /**
     * Obtenir l'utilisateur associé au suivi d'utilisation.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtenir l'abonnement associé au suivi d'utilisation.
     */
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(UserSubscription::class, 'user_subscription_id');
    }

    /**
     * Incrémenter le compteur d'utilisation.
     *
     * @param int $amount Montant à incrémenter (par défaut 1)
     * @param array $details Détails supplémentaires à enregistrer
     * @return bool
     */
    public function increment(int $amount = 1, array $details = []): bool
    {
        // Vérifier si le compteur doit être réinitialisé (par exemple, nouveau mois)
        $this->checkAndResetIfNeeded();

        // Mettre à jour le compteur
        $this->count += $amount;
        
        // Ajouter des détails si fournis
        if (!empty($details)) {
            $currentDetails = $this->details ?? [];
            $this->details = array_merge($currentDetails, $details);
        }
        
        return $this->save();
    }

    /**
     * Vérifier si le compteur doit être réinitialisé et le réinitialiser si nécessaire.
     *
     * @return bool True si réinitialisé, false sinon
     */
    public function checkAndResetIfNeeded(): bool
    {
        if (!$this->reset_at || Carbon::now() >= $this->reset_at) {
            $this->count = 0;
            
            // Définir la prochaine date de réinitialisation (généralement le premier jour du mois prochain)
            $this->reset_at = Carbon::now()->firstOfMonth()->addMonth();
            
            return $this->save();
        }
        
        return false;
    }

    /**
     * Vérifier si l'utilisateur a atteint sa limite pour cette fonctionnalité.
     *
     * @param int $limit Limite à vérifier
     * @return bool True si la limite est atteinte ou dépassée
     */
    public function hasReachedLimit(int $limit): bool
    {
        $this->checkAndResetIfNeeded();
        return $this->count >= $limit;
    }

    /**
     * Calculer le pourcentage d'utilisation par rapport à une limite.
     *
     * @param int $limit Limite à utiliser pour le calcul
     * @return float Pourcentage d'utilisation (0-100)
     */
    public function usagePercentage(int $limit): float
    {
        if ($limit <= 0) {
            return 100;
        }
        
        $this->checkAndResetIfNeeded();
        return min(100, ($this->count / $limit) * 100);
    }

    /**
     * Scope pour filtrer par type de fonctionnalité.
     */
    public function scopeOfType($query, string $featureType)
    {
        return $query->where('feature_type', $featureType);
    }

    /**
     * Scope pour filtrer les enregistrements de la période en cours.
     */
    public function scopeCurrentPeriod($query)
    {
        return $query->where('reset_at', '>', Carbon::now());
    }

    /**
     * Scope pour filtrer les enregistrements approchant de leur limite.
     */
    public function scopeNearingLimit($query, int $percentage = 80)
    {
        return $query->whereRaw('(count / ?) * 100 >= ?', [$percentage, $percentage]);
    }
}
