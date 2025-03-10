<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Exécute le seeding des plans d'abonnement.
     */
    public function run(): void
    {
        // Récupérer les devises nécessaires
        $xaf = Currency::where('code', 'XAF')->first();
        $eur = Currency::where('code', 'EUR')->first();
        $usd = Currency::where('code', 'USD')->first();
        
        // S'assurer que les devises existent
        if (!$xaf || !$eur || !$usd) {
            $this->command->error("Les devises nécessaires n'existent pas. Exécutez d'abord CurrencySeeder.");
            return;
        }
        // Plan Gratuit
        SubscriptionPlan::create([
            'name' => 'Gratuit',
            'slug' => 'gratuit',
            'description' => 'Accès de base à la protection de documents avec des fonctionnalités limitées.',
            'price_monthly' => 0,
            'price_yearly' => 0,
            'currency_id' => $xaf->id,
            'features' => [
                'monthly_generations' => 5,
                'max_document_size' => 10, // MB
                'document_types' => ['pdf'],
                'watermark_options' => ['text'],
                'storage_duration' => 7, // jours
                'max_shares' => 3,
                'password_protection' => false,
                'tracking' => false,
                'expiration' => false,
                'support' => 'email_48h',
                'api_access' => false,
                'reports' => false,
                'users_per_account' => 1,
            ],
            'is_active' => true,
            'sort_order' => 1,
        ]);

        // Plan Basique
        SubscriptionPlan::create([
            'name' => 'Basique',
            'slug' => 'basique',
            'description' => 'Protection avancée pour les professionnels avec des fonctionnalités étendues.',
            'price_monthly' => 5000,
            'price_yearly' => 50000,
            'currency_id' => $xaf->id,
            'features' => [
                'monthly_generations' => 100,
                'max_document_size' => 50, // MB
                'document_types' => ['pdf', 'jpg', 'png'],
                'watermark_options' => ['text', 'color'],
                'storage_duration' => 30, // jours
                'max_shares' => 20,
                'password_protection' => true,
                'tracking' => 'basic',
                'expiration' => true,
                'support' => 'email_24h',
                'api_access' => 'limited',
                'reports' => 'monthly',
                'users_per_account' => 3,
            ],
            'is_active' => true,
            'sort_order' => 2,
        ]);

        // Plan Premium
        SubscriptionPlan::create([
            'name' => 'Premium',
            'slug' => 'premium',
            'description' => 'Solution complète de protection de documents avec toutes les fonctionnalités premium.',
            'price_monthly' => 15000,
            'price_yearly' => 150000,
            'currency_id' => $xaf->id,
            'features' => [
                'monthly_generations' => -1, // illimité
                'max_document_size' => 200, // MB
                'document_types' => ['pdf', 'jpg', 'png', 'docx', 'xlsx'],
                'watermark_options' => ['text', 'logo', 'position', 'opacity'],
                'storage_duration' => 365, // jours
                'max_shares' => -1, // illimité
                'password_protection' => true,
                'tracking' => 'detailed',
                'expiration' => 'advanced',
                'support' => 'priority',
                'api_access' => 'full',
                'reports' => 'weekly',
                'users_per_account' => 10,
            ],
            'is_active' => true,
            'sort_order' => 3,
        ]);
        
        // Plan Pro en euros
        SubscriptionPlan::create([
            'name' => 'Pro (EUR)',
            'slug' => 'pro-eur',
            'description' => 'Solutions pour les entreprises internationales avec paiement en euros.',
            'price_monthly' => 29.99,
            'price_yearly' => 299.90,
            'currency_id' => $eur->id,
            'features' => [
                'monthly_generations' => -1, // illimité
                'max_document_size' => 500, // MB
                'document_types' => ['pdf', 'jpg', 'png', 'docx', 'xlsx', 'pptx'],
                'watermark_options' => ['text', 'logo', 'position', 'opacity', 'custom'],
                'storage_duration' => 730, // jours (2 ans)
                'max_shares' => -1, // illimité
                'password_protection' => true,
                'tracking' => 'detailed',
                'expiration' => 'advanced',
                'support' => 'dedicated',
                'api_access' => 'enterprise',
                'reports' => 'daily',
                'users_per_account' => 25,
            ],
            'is_active' => true,
            'sort_order' => 4,
        ]);
        
        // Plan Enterprise en dollars
        SubscriptionPlan::create([
            'name' => 'Enterprise (USD)',
            'slug' => 'enterprise-usd',
            'description' => 'Solution complète pour les multinationales avec paiement en dollars.',
            'price_monthly' => 49.99,
            'price_yearly' => 499.90,
            'currency_id' => $usd->id,
            'features' => [
                'monthly_generations' => -1, // illimité
                'max_document_size' => 1000, // MB (1GB)
                'document_types' => ['pdf', 'jpg', 'png', 'docx', 'xlsx', 'pptx', 'custom'],
                'watermark_options' => ['text', 'logo', 'position', 'opacity', 'custom', 'enterprise'],
                'storage_duration' => -1, // permanent
                'max_shares' => -1, // illimité
                'password_protection' => true,
                'tracking' => 'enterprise',
                'expiration' => 'enterprise',
                'support' => '24_7',
                'api_access' => 'unlimited',
                'reports' => 'realtime',
                'users_per_account' => -1, // illimité
            ],
            'is_active' => true,
            'sort_order' => 5,
        ]);
    }
}
