<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubscriptionPayment extends Model
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
        'amount',
        'currency',
        'payment_method',
        'payment_provider', // 'stripe', 'paypal', etc.
        'transaction_id',
        'invoice_id',
        'status', // 'pending', 'completed', 'failed', 'refunded'
        'payment_details',
        'billing_period_start',
        'billing_period_end',
        'paid_at',
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'payment_details' => 'array',
        'billing_period_start' => 'datetime',
        'billing_period_end' => 'datetime',
        'paid_at' => 'datetime',
    ];

    /**
     * Obtenir l'utilisateur qui a effectué le paiement.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtenir l'abonnement associé au paiement.
     */
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(UserSubscription::class, 'user_subscription_id');
    }

    /**
     * Vérifier si le paiement est en attente.
     *
     * @return bool
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Vérifier si le paiement est complété.
     *
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Vérifier si le paiement a échoué.
     *
     * @return bool
     */
    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    /**
     * Vérifier si le paiement a été remboursé.
     *
     * @return bool
     */
    public function isRefunded(): bool
    {
        return $this->status === 'refunded';
    }

    /**
     * Générer un numéro d'invoice formaté.
     *
     * @return string
     */
    public function getFormattedInvoiceNumber(): string
    {
        return 'INV-' . str_pad($this->id, 8, '0', STR_PAD_LEFT);
    }

    /**
     * Scope pour les paiements en attente.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope pour les paiements complétés.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope pour les paiements échoués.
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /**
     * Scope pour les paiements remboursés.
     */
    public function scopeRefunded($query)
    {
        return $query->where('status', 'refunded');
    }
}
