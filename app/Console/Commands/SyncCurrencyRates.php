<?php

namespace App\Console\Commands;

use App\Models\Currency;
use App\Services\CurrencyExchangeService;
use Illuminate\Console\Command;

class SyncCurrencyRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronise les taux de change des devises avec une API externe';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Démarrage de la synchronisation des taux de change...');
        
        try {
            $service = new CurrencyExchangeService();
            $updatedCount = $service->syncRatesToDatabase();
            
            if ($updatedCount > 0) {
                $this->info("Synchronisation réussie! {$updatedCount} devises mises à jour.");
            } else {
                $this->warn("Aucune devise n'a été mise à jour. Utilisation des taux fixes.");
                $this->syncFixedRates();
            }
            
            return 0;
        } catch (\Exception $e) {
            $this->error('Exception: ' . $e->getMessage());
            $this->syncFixedRates();
            return 1;
        }
    }
    

    
    /**
     * Synchronise les taux fixes pour les devises africaines
     */
    private function syncFixedRates()
    {
        $this->info('Mise à jour des taux de change fixes...');
        
        // Taux de change fixes (XAF et XOF ont une parité fixe avec l'EUR)
        $fixedRates = [
            'XAF' => 655.957,
            'XOF' => 655.957,
            'EUR' => 1.0,
            'USD' => 1.08, // Taux approximatif, à mettre à jour manuellement si nécessaire
        ];
        
        foreach ($fixedRates as $code => $rate) {
            $currency = \App\Models\Currency::where('code', $code)->first();
            
            if ($currency) {
                $currency->exchange_rate = $rate;
                $currency->save();
                $this->info("Devise {$code} mise à jour avec le taux fixe: {$rate}");
            }
        }
    }
}
