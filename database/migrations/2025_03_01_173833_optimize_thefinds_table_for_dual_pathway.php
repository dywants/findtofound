<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('thefinds', function (Blueprint $table) {
            // Ajouter le champ qui indique explicitement si l'utilisateur veut une récompense
            $table->boolean('want_reward')->default(true)->after('is_anonymous');
            
            // Ajouter un champ deposit_date pour stocker la date de dépôt
            $table->date('deposit_date')->nullable()->after('discovery_date');
            
            // Ajouter un index sur les champs clés pour améliorer les performances des requêtes
            $table->index(['want_reward', 'is_anonymous']);
        });
        
        // Mettre à jour les données existantes
        DB::statement("UPDATE thefinds SET want_reward = TRUE");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('thefinds', function (Blueprint $table) {
            $table->dropColumn('want_reward');
            $table->dropColumn('deposit_date');
            $table->dropIndex(['want_reward', 'is_anonymous']);
        });
    }
};
