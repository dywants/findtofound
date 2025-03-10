<?php

namespace App\Services;

use App\Models\Currency;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class CurrencyExchangeService
{
    /**
     * Temps de mise en cache des taux en minutes (1 jour)
     */
    const CACHE_TIME = 1440;
    
    /**
     * Récupère les taux de change depuis une source externe
     * 
     * @return array|null Taux de change ou null en cas d'erreur
     */
    public function fetchExchangeRates(): ?array
    {
        // Vérifier si les taux sont en cache
        if (Cache::has('currency_exchange_rates')) {
            return Cache::get('currency_exchange_rates');
        }
        
        // Essayer plusieurs APIs gratuites sans authentification
        $apis = [
            $this->fetchFromFreeCurrencyApi(),
            $this->fetchFromExchangeRateApi(),
            $this->fetchFromEcbEuropa(),
        ];
        
        foreach ($apis as $result) {
            if ($result) {
                // Mettre en cache les résultats
                Cache::put('currency_exchange_rates', $result, self::CACHE_TIME);
                return $result;
            }
        }
        
        // Si toutes les API échouent, utiliser les taux fixes
        return $this->getFixedRates();
    }
    
    /**
     * Tente de récupérer les taux depuis FreeCurrency API
     */
    private function fetchFromFreeCurrencyApi(): ?array
    {
        try {
            $response = Http::get('https://cdn.jsdelivr.net/gh/fawazahmed0/currency-api@1/latest/currencies/eur.json');
            
            if ($response->successful()) {
                $data = $response->json();
                $rates = $data['eur'] ?? [];
                
                if (!empty($rates)) {
                    return [
                        'base' => 'EUR',
                        'rates' => [
                            'XAF' => 655.957, // Taux fixe
                            'XOF' => 655.957, // Taux fixe
                            'EUR' => 1.0,
                            'USD' => $rates['usd'] ?? 1.08,
                            // Autres devises si nécessaire
                        ]
                    ];
                }
            }
        } catch (\Exception $e) {
            Log::warning('Échec de récupération depuis FreeCurrency API: ' . $e->getMessage());
        }
        
        return null;
    }
    
    /**
     * Tente de récupérer les taux depuis ExchangeRate API (version gratuite)
     */
    private function fetchFromExchangeRateApi(): ?array
    {
        try {
            $response = Http::get('https://open.er-api.com/v6/latest/EUR');
            
            if ($response->successful()) {
                $data = $response->json();
                $rates = $data['rates'] ?? [];
                
                if (!empty($rates)) {
                    return [
                        'base' => 'EUR',
                        'rates' => [
                            'XAF' => 655.957, // Taux fixe
                            'XOF' => 655.957, // Taux fixe
                            'EUR' => 1.0,
                            'USD' => $rates['USD'] ?? 1.08,
                            // Autres devises si nécessaire
                        ]
                    ];
                }
            }
        } catch (\Exception $e) {
            Log::warning('Échec de récupération depuis ExchangeRate API: ' . $e->getMessage());
        }
        
        return null;
    }
    
    /**
     * Tente de récupérer les taux depuis la Banque Centrale Européenne
     */
    private function fetchFromEcbEuropa(): ?array
    {
        try {
            $response = Http::get('https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml');
            
            if ($response->successful()) {
                $xml = simplexml_load_string($response->body());
                $rates = [];
                
                // Traiter le XML de la BCE
                if ($xml && isset($xml->Cube->Cube->Cube)) {
                    foreach ($xml->Cube->Cube->Cube as $rate) {
                        $currency = (string)$rate['currency'];
                        $value = (float)$rate['rate'];
                        $rates[$currency] = $value;
                    }
                    
                    return [
                        'base' => 'EUR',
                        'rates' => [
                            'XAF' => 655.957, // Taux fixe
                            'XOF' => 655.957, // Taux fixe
                            'EUR' => 1.0,
                            'USD' => $rates['USD'] ?? 1.08,
                            // Autres devises si nécessaire
                        ]
                    ];
                }
            }
        } catch (\Exception $e) {
            Log::warning('Échec de récupération depuis BCE: ' . $e->getMessage());
        }
        
        return null;
    }
    
    /**
     * Retourne les taux de change fixes pour les devises courantes
     */
    public function getFixedRates(): array
    {
        return [
            'base' => 'EUR',
            'rates' => [
                'XAF' => 655.957,
                'XOF' => 655.957,
                'EUR' => 1.0,
                'USD' => 1.08,
            ]
        ];
    }
    
    /**
     * Synchronise les taux de change dans la base de données
     */
    public function syncRatesToDatabase(): int
    {
        $rates = $this->fetchExchangeRates();
        
        if (!$rates || empty($rates['rates'])) {
            Log::error('Impossible de synchroniser les taux: données invalides');
            return 0;
        }
        
        $updatedCount = 0;
        
        foreach (['XAF', 'XOF', 'EUR', 'USD'] as $code) {
            if (isset($rates['rates'][$code])) {
                $rate = $rates['rates'][$code];
                $currency = Currency::where('code', $code)->first();
                
                if ($currency) {
                    $currency->exchange_rate = $rate;
                    $currency->save();
                    $updatedCount++;
                }
            }
        }
        
        return $updatedCount;
    }
    
    /**
     * Convertit un montant d'une devise à une autre
     */
    public function convert(float $amount, string $fromCurrency, string $toCurrency): float
    {
        // Si les devises sont identiques, pas de conversion nécessaire
        if ($fromCurrency === $toCurrency) {
            return $amount;
        }
        
        // Récupérer les devises
        $from = Currency::where('code', $fromCurrency)->first();
        $to = Currency::where('code', $toCurrency)->first();
        
        // Si une devise n'est pas trouvée, retourner le montant original
        if (!$from || !$to) {
            return $amount;
        }
        
        // Convertir via l'EUR comme devise de base
        $amountInEur = $amount / $from->exchange_rate;
        $convertedAmount = $amountInEur * $to->exchange_rate;
        
        // Arrondir selon les conventions de la devise cible
        return round($convertedAmount, $to->decimal_places);
    }
}
