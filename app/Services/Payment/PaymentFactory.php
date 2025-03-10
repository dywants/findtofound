<?php

namespace App\Services\Payment;

use InvalidArgumentException;

class PaymentFactory
{
    /**
     * Créer une instance du service de paiement approprié
     *
     * @param string $provider Le fournisseur de paiement ('paypal', 'afrikpay', etc.)
     * @return PaymentServiceInterface
     * @throws InvalidArgumentException Si le fournisseur n'est pas supporté
     */
    public static function create(string $provider): PaymentServiceInterface
    {
        switch (strtolower($provider)) {
            case 'paypal':
                return app(PaypalService::class);
                
            case 'afrikpay':
                return app(AfrikpayService::class);
            
            case 'flutterwave':
                return app(FlutterwaveService::class);
                
            default:
                throw new InvalidArgumentException("Fournisseur de paiement non supporté: {$provider}");
        }
    }
}
