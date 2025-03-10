<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Currency;
use App\Models\SubscriptionPlan;
use App\Services\CurrencyExchangeService;

echo "---------------------------------------------\n";
echo "        TEST DU SYSTÈME MULTI-DEVISE        \n";
echo "---------------------------------------------\n\n";

// 1. Test des taux de change
echo "1. TAUX DE CHANGE ACTUELS\n";
echo "------------------------\n";

$service = new CurrencyExchangeService();
$ratesData = $service->fetchExchangeRates();

if (empty($ratesData) || !isset($ratesData['rates'])) {
    echo "Aucun taux de change trouvé ou format incorrect. Exécutez 'php artisan currency:sync' d'abord.\n";
} else {
    echo "Base: {$ratesData['base']}\n";
    echo "Taux de change:\n";
    
    foreach ($ratesData['rates'] as $currency => $rate) {
        echo "{$currency}: {$rate}\n";
    }
}

echo "\n";

// 2. Test des devises en base de données
echo "2. DEVISES EN BASE DE DONNÉES\n";
echo "----------------------------\n";

$currencies = Currency::all();

if ($currencies->isEmpty()) {
    echo "Aucune devise trouvée en base de données. Exécutez 'php artisan db:seed --class=CurrencySeeder' d'abord.\n";
} else {
    echo sprintf("%-5s %-20s %-10s %-15s %-10s %-10s\n", "Code", "Nom", "Symbole", "Taux", "Décimales", "Défaut");
    echo str_repeat("-", 75) . "\n";
    
    foreach ($currencies as $currency) {
        echo sprintf(
            "%-5s %-20s %-10s %-15s %-10s %-10s\n",
            $currency->code,
            substr($currency->name, 0, 18),
            $currency->symbol,
            $currency->exchange_rate,
            $currency->decimal_places,
            $currency->is_default ? 'Oui' : 'Non'
        );
    }
}

echo "\n";

// 3. Test de formatage des montants
echo "3. FORMATAGE DES MONTANTS\n";
echo "------------------------\n";

$amount = 1234.56;

if ($currencies->isEmpty()) {
    echo "Impossible de tester le formatage sans devises.\n";
} else {
    foreach ($currencies as $currency) {
        $formatted = $currency->formatAmount($amount);
        echo "{$currency->code}: {$formatted}\n";
    }
}

echo "\n";

// 4. Test de conversion entre devises
echo "4. CONVERSION ENTRE DEVISES\n";
echo "---------------------------\n";

if ($currencies->count() < 2) {
    echo "Impossible de tester la conversion sans au moins 2 devises.\n";
} else {
    $amount = 1000;
    $baseCurrency = $currencies->firstWhere('is_default', true) ?: $currencies->first();
    
    echo "Montant de base: {$amount} {$baseCurrency->code}\n";
    echo "Conversions:\n";
    
    foreach ($currencies as $targetCurrency) {
        if ($targetCurrency->id !== $baseCurrency->id) {
            // 2 méthodes de conversion
            // 1. Via le service directement
            $convertedAmount1 = $service->convert($amount, $baseCurrency->code, $targetCurrency->code);
            
            // 2. Via la méthode du modèle Currency (si elle existe)
            if (method_exists($baseCurrency, 'convertTo')) {
                $convertedAmount2 = $baseCurrency->convertTo($amount, $targetCurrency);
            } else {
                // Sinon utiliser la méthode de formatage pour comparaison
                $convertedAmount2 = $convertedAmount1;
            }
            
            echo "{$targetCurrency->code}: {$convertedAmount1} ({$targetCurrency->formatAmount($convertedAmount1)})\n";
            
            if (abs($convertedAmount1 - $convertedAmount2) > 0.01) {
                echo "   ATTENTION: Écart de conversion détecté entre les méthodes!\n";
                echo "   Méthode 2: {$convertedAmount2} ({$targetCurrency->formatAmount($convertedAmount2)})\n";
            }
        }
    }
}

echo "\n";

// 5. Test avec un plan d'abonnement
echo "5. PRIX DES PLANS D'ABONNEMENT\n";
echo "-----------------------------\n";

$plans = SubscriptionPlan::with('currency')->get();

if ($plans->isEmpty()) {
    echo "Aucun plan d'abonnement trouvé.\n";
} else {
    foreach ($plans as $plan) {
        echo "Plan: {$plan->name}\n";
        echo "  Prix mensuel: {$plan->formatted_monthly_price}\n";
        echo "  Prix annuel: {$plan->formatted_yearly_price}\n";
        echo "  Devise d'origine: {$plan->currency->code}\n";
        echo "  Prix dans d'autres devises:\n";
        
        foreach ($currencies as $currency) {
            if ($currency->id !== $plan->currency_id) {
                $monthlyPrice = $plan->getPriceInCurrency($plan->price_monthly, $currency);
                $yearlyPrice = $plan->getPriceInCurrency($plan->price_yearly, $currency);
                
                echo "    {$currency->code}: " . 
                     $currency->formatAmount($monthlyPrice) . " (mensuel), " . 
                     $currency->formatAmount($yearlyPrice) . " (annuel)\n";
            }
        }
        echo "\n";
    }
}

echo "---------------------------------------------\n";
echo "        FIN DES TESTS MULTI-DEVISE          \n";
echo "---------------------------------------------\n";