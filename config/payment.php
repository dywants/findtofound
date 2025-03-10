<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Configuration des Services de Paiement
    |--------------------------------------------------------------------------
    |
    | Ce fichier contient les configurations pour les différentes passerelles
    | de paiement utilisées par l'application.
    |
    */

    'paypal' => [
        // Mode Sandbox (développement) ou Production
        'sandbox' => env('PAYPAL_SANDBOX', true),
        
        // Identifiants d'API
        'client_id' => env('PAYPAL_CLIENT_ID', ''),
        'client_secret' => env('PAYPAL_CLIENT_SECRET', ''),
        
        // Configuration des webhooks
        'webhook_id' => env('PAYPAL_WEBHOOK_ID', ''),
    ],
    
    'afrikpay' => [
        // Mode Sandbox (développement) ou Production
        'sandbox' => env('AFRIKPAY_SANDBOX', true),
        
        // Identifiants d'API
        'api_key' => env('AFRIKPAY_API_KEY', ''),
        'secret_key' => env('AFRIKPAY_SECRET_KEY', ''),
        'merchant_id' => env('AFRIKPAY_MERCHANT_ID', ''),
    ],
    
    'flutterwave' => [
        // Mode Sandbox (développement) ou Production
        'sandbox' => env('FLUTTERWAVE_SANDBOX', true),
        
        // Identifiants d'API
        'public_key' => env('FLUTTERWAVE_PUBLIC_KEY', ''),
        'secret_key' => env('FLUTTERWAVE_SECRET_KEY', ''),
        'encryption_key' => env('FLUTTERWAVE_ENCRYPTION_KEY', ''),
        
        // Hash de vérification pour les webhooks
        'webhook_hash' => env('FLUTTERWAVE_WEBHOOK_HASH', ''),
    ],
    
    // Transaction timeout en minutes
    'transaction_timeout' => env('PAYMENT_TRANSACTION_TIMEOUT', 60),
    
    // Devise par défaut
    'default_currency' => env('DEFAULT_CURRENCY', 'XAF'),
];
