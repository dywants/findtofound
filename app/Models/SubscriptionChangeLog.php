<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubscriptionChangeLog extends Model
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
        'previous_plan_id',
        'new_plan_id',
        'change_type', // 'upgrade', 'downgrade', 'renewal', 'cancellation', 'reactivation'
        'reason',
        'details',
        'changed_by_user_id', // ID de l'utilisateur qui a effectué le changement (admin ou utilisateur)
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'details' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Obtenir l'utilisateur concerné par le changement.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtenir l'abonnement concerné par le changement.
     */
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(UserSubscription::class, 'user_subscription_id');
    }

    /**
     * Obtenir le plan précédent.
     */
    public function previousPlan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class, 'previous_plan_id');
    }

    /**
     * Obtenir le nouveau plan.
     */
    public function newPlan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class, 'new_plan_id');
    }

    /**
     * Obtenir l'utilisateur qui a effectué le changement.
     */
    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by_user_id');
    }

    /**
     * Vérifier si le changement est une mise à niveau.
     *
     * @return bool
     */
    public function isUpgrade(): bool
    {
        return $this->change_type === 'upgrade';
    }

    /**
     * Vérifier si le changement est une rétrogradation.
     *
     * @return bool
     */
    public function isDowngrade(): bool
    {
        return $this->change_type === 'downgrade';
    }

    /**
     * Vérifier si le changement est un renouvellement.
     *
     * @return bool
     */
    public function isRenewal(): bool
    {
        return $this->change_type === 'renewal';
    }

    /**
     * Vérifier si le changement est une annulation.
     *
     * @return bool
     */
    public function isCancellation(): bool
    {
        return $this->change_type === 'cancellation';
    }

    /**
     * Vérifier si le changement est une réactivation.
     *
     * @return bool
     */
    public function isReactivation(): bool
    {
        return $this->change_type === 'reactivation';
    }

    /**
     * Scope pour filtrer par type de changement.
     */
    public function scopeOfType($query, string $changeType)
    {
        return $query->where('change_type', $changeType);
    }

    /**
     * Scope pour filtrer les changements récents.
     */
    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}
