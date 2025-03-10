<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class UserSubscription extends Model
{
    use HasFactory;

    /**
     * Les attributs assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'subscription_plan_id',
        'starts_at',
        'ends_at',
        'billing_cycle', // 'monthly' ou 'yearly'
        'status', // 'active', 'canceled', 'expired', 'pending'
        'auto_renew',
        'cancellation_reason',
        'payment_method',
        'last_payment_id',
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'auto_renew' => 'boolean',
    ];

    /**
     * Obtenir l'utilisateur propriétaire de l'abonnement.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtenir le plan d'abonnement.
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id');
    }

    /**
     * Obtenir les paiements liés à cet abonnement.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(SubscriptionPayment::class);
    }

    /**
     * Obtenir le dernier paiement.
     */
    public function lastPayment(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPayment::class, 'last_payment_id');
    }

    /**
     * Vérifier si l'abonnement est actif.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->status === 'active' && 
               $this->ends_at > Carbon::now();
    }

    /**
     * Vérifier si l'abonnement est expiré.
     *
     * @return bool
     */
    public function isExpired(): bool
    {
        return $this->status === 'expired' || 
               ($this->ends_at && $this->ends_at < Carbon::now());
    }

    /**
     * Vérifier si l'abonnement est annulé.
     *
     * @return bool
     */
    public function isCanceled(): bool
    {
        return $this->status === 'canceled';
    }

    /**
     * Vérifier si l'abonnement est en attente.
     *
     * @return bool
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Vérifier si l'abonnement se renouvelle automatiquement.
     *
     * @return bool
     */
    public function willAutoRenew(): bool
    {
        return $this->auto_renew && $this->isActive();
    }

    /**
     * Calculer le nombre de jours restants avant expiration.
     *
     * @return int
     */
    public function daysRemaining(): int
    {
        if (!$this->ends_at || !$this->isActive()) {
            return 0;
        }

        return Carbon::now()->diffInDays($this->ends_at, false);
    }

    /**
     * Calculer le pourcentage de temps écoulé dans l'abonnement.
     *
     * @return float
     */
    public function progressPercentage(): float
    {
        if (!$this->starts_at || !$this->ends_at || !$this->isActive()) {
            return 0;
        }

        $total = $this->starts_at->diffInDays($this->ends_at);
        $elapsed = $this->starts_at->diffInDays(Carbon::now());

        if ($total === 0) {
            return 100;
        }

        return min(100, max(0, ($elapsed / $total) * 100));
    }

    /**
     * Scope pour les abonnements actifs.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                     ->where(function($q) {
                         $q->whereNull('ends_at')
                           ->orWhere('ends_at', '>', Carbon::now());
                     });
    }

    /**
     * Scope pour les abonnements expirés.
     */
    public function scopeExpired($query)
    {
        return $query->where(function($q) {
                         $q->where('status', 'expired')
                           ->orWhere(function($sq) {
                               $sq->whereNotNull('ends_at')
                                  ->where('ends_at', '<', Carbon::now());
                           });
                     });
    }

    /**
     * Scope pour les abonnements qui expirent bientôt (dans les 7 jours).
     */
    public function scopeExpiringSoon($query, $days = 7)
    {
        return $query->where('status', 'active')
                     ->whereNotNull('ends_at')
                     ->whereBetween('ends_at', [Carbon::now(), Carbon::now()->addDays($days)]);
    }
}
