<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'paypal' => [
        'client_id' => env('PAYPAL_CLIENT_ID'),
        'secret' => env('PAYPAL_SECRET'),
        'currency' => env('PAYPAL_CURRENCY', 'EUR'),
        'mode' => env('PAYPAL_MODE', 'sandbox'),
        'sandbox' => env('PAYPAL_MODE', 'sandbox') === 'sandbox',
    ],

    /*
    |--------------------------------------------------------------------------
    | Services de taux de change
    |--------------------------------------------------------------------------
    |
    | Configuration des services pour obtenir les taux de change entre devises.
    |
    */
    'exchange_rate' => [
        'key' => env('EXCHANGE_RATE_API_KEY'),
        'provider' => env('EXCHANGE_RATE_PROVIDER', 'exchangerate-api'),
        'base_currency' => env('EXCHANGE_RATE_BASE_CURRENCY', 'EUR'),
        'update_frequency' => env('EXCHANGE_RATE_UPDATE_FREQUENCY', 'daily'), // daily, weekly, manual
    ],

    /*
    |--------------------------------------------------------------------------
    | Services d'authentification sociale
    |--------------------------------------------------------------------------
    |
    | Configuration pour Google et Facebook OAuth.
    |
    */
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI', 'http://localhost:8000/auth/google/callback'),
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT_URI', 'http://localhost:8000/auth/facebook/callback'),
    ],

];
