<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            // Ajout de la référence à la devise pour les prix
            // On garde les colonnes de prix existantes (price_monthly, price_yearly) telles quelles
            // Les prix seront stockés en XAF par défaut
            $table->foreignId('currency_id')->nullable()->after('sort_order')->comment('Devise dans laquelle les prix sont stockés (XAF par défaut)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            // Suppression de la référence à la devise
            $table->dropColumn('currency_id');
        });
    }
};
