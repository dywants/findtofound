<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tableau des devises à créer
        $currencies = [
            [
                'code' => 'XAF',
                'name' => 'Franc CFA BEAC',
                'symbol' => 'FCFA',
                'exchange_rate' => 655.957, // Par rapport à 1 EUR
                'is_active' => true,
                'is_default' => true, // Devise par défaut
                'decimal_places' => 0, // Les francs CFA sont généralement affichés sans décimales
            ],
            [
                'code' => 'XOF',
                'name' => 'Franc CFA BCEAO',
                'symbol' => 'FCFA',
                'exchange_rate' => 655.957, // Par rapport à 1 EUR
                'is_active' => true,
                'is_default' => false,
                'decimal_places' => 0,
            ],
            [
                'code' => 'EUR',
                'name' => 'Euro',
                'symbol' => '€',
                'exchange_rate' => 1.0, // Taux de référence
                'is_active' => true,
                'is_default' => false,
                'decimal_places' => 2,
            ],
            [
                'code' => 'USD',
                'name' => 'Dollar américain',
                'symbol' => '$',
                'exchange_rate' => 1.08, // Taux approximatif EUR/USD - à actualiser régulièrement
                'is_active' => true,
                'is_default' => false,
                'decimal_places' => 2,
            ],
        ];

        // Insérer chaque devise dans la base de données
        foreach ($currencies as $currencyData) {
            // Vérifier si la devise existe déjà (pour éviter les doublons lors de l'exécution répétée du seeder)
            $exists = Currency::where('code', $currencyData['code'])->exists();
            
            if (!$exists) {
                Currency::create($currencyData);
            }
        }
        
        // S'assurer qu'il n'y a qu'une seule devise par défaut
        if (Currency::where('is_default', true)->count() > 1) {
            // Définir tous comme non-défaut
            Currency::where('is_default', true)
                ->where('code', '!=', 'XAF')
                ->update(['is_default' => false]);
        }
    }
}
