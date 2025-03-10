<?php

namespace App\Models;

use App\Traits\HasAvatar;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasAvatar, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function avatarurl(): string
    {
        return 'https://www.gravatar.com/avatar/'. md5(strtolower(trim( $this->email)));
    }

    /**
     * @param int $size
     * @return string
     */
    public function getAvatar(int $size = 64 ): string
    {
        return $this->getGravatar( $this->email, $size );
    }

    /**
     * @return BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * @return HasOne
     */
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * @return HasMany
     */
    public function finds(): HasMany
    {
        return $this->hasMany(Thefind::class, 'user_id');
    }

    public function thefound(): HasOne
    {
        return $this->hasOne(Thefound::class, 'user_id');
    }

    /**
     * Relation avec les documents protégés de l'utilisateur
     * 
     * @return HasMany
     */
    public function protectedDocuments(): HasMany
    {
        return $this->hasMany(ProtectedDocument::class);
    }

    /**
     * Relation avec les abonnements de l'utilisateur
     * 
     * @return HasMany
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(UserSubscription::class);
    }

    /**
     * Obtenir l'abonnement actif de l'utilisateur
     * 
     * @return UserSubscription|null
     */
    public function activeSubscription()
    {
        return $this->subscriptions()
                    ->where('status', 'active')
                    ->where(function($query) {
                        $query->whereNull('ends_at')
                              ->orWhere('ends_at', '>', Carbon::now());
                    })
                    ->latest('starts_at')
                    ->first();
    }

    /**
     * Relation avec les paiements d'abonnement de l'utilisateur
     * 
     * @return HasMany
     */
    public function subscriptionPayments(): HasMany
    {
        return $this->hasMany(SubscriptionPayment::class);
    }

    /**
     * Relation avec le suivi d'utilisation de l'utilisateur
     * 
     * @return HasMany
     */
    public function usageTracking(): HasMany
    {
        return $this->hasMany(UsageTracking::class);
    }

    /**
     * Relation avec l'historique des changements d'abonnement de l'utilisateur
     * 
     * @return HasMany
     */
    public function subscriptionChangeLogs(): HasMany
    {
        return $this->hasMany(SubscriptionChangeLog::class);
    }

    /**
     * Vérifie si l'utilisateur a un abonnement actif
     * 
     * @return bool
     */
    public function hasActiveSubscription(): bool
    {
        return $this->activeSubscription() !== null;
    }

    /**
     * Obtenir le plan d'abonnement actif de l'utilisateur
     * 
     * @return SubscriptionPlan|null
     */
    public function currentPlan()
    {
        $subscription = $this->activeSubscription();
        return $subscription ? $subscription->plan : null;
    }

    /**
     * Vérifie si l'utilisateur a atteint sa limite pour une fonctionnalité donnée
     * 
     * @param string $featureType Type de fonctionnalité à vérifier
     * @return bool
     */
    public function hasReachedUsageLimit(string $featureType): bool
    {
        $plan = $this->currentPlan();
        if (!$plan) {
            return true; // Sans plan, considérer que la limite est atteinte
        }

        // Obtenir la limite pour cette fonctionnalité
        $limit = 0;
        switch ($featureType) {
            case 'document_generation':
                $limit = $plan->getMonthlyGenerationLimit();
                break;
            // Ajouter d'autres types de fonctionnalités au besoin
        }

        // Si la limite est illimitée (0 ou négatif), retourner false
        if ($limit <= 0) {
            return false;
        }

        // Vérifier l'utilisation actuelle
        $usage = $this->usageTracking()
                      ->where('feature_type', $featureType)
                      ->where('reset_at', '>', Carbon::now())
                      ->first();

        if (!$usage) {
            return false; // Pas d'utilisation enregistrée, donc pas de limite atteinte
        }

        return $usage->count >= $limit;
    }

    /**
     * Obtenir le pourcentage d'utilisation pour une fonctionnalité donnée
     * 
     * @param string $featureType Type de fonctionnalité
     * @return float Pourcentage d'utilisation (0-100)
     */
    public function getUsagePercentage(string $featureType): float
    {
        $plan = $this->currentPlan();
        if (!$plan) {
            return 100; // Sans plan, considérer que l'utilisation est à 100%
        }

        // Obtenir la limite pour cette fonctionnalité
        $limit = 0;
        switch ($featureType) {
            case 'document_generation':
                $limit = $plan->getMonthlyGenerationLimit();
                break;
            // Ajouter d'autres types de fonctionnalités au besoin
        }

        // Si la limite est illimitée (0 ou négatif), retourner 0%
        if ($limit <= 0) {
            return 0;
        }

        // Vérifier l'utilisation actuelle
        $usage = $this->usageTracking()
                      ->where('feature_type', $featureType)
                      ->where('reset_at', '>', Carbon::now())
                      ->first();

        if (!$usage) {
            return 0; // Pas d'utilisation enregistrée
        }

        return min(100, ($usage->count / $limit) * 100);
    }
}
