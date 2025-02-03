<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enum\PieceCondition;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('thefinds', function (Blueprint $table) {
            // Champs pour le mode anonyme
            $table->string('contact_person')->nullable();
            $table->text('pickup_hours')->nullable();
            $table->text('special_instructions')->nullable();

            // Champs pour la date de découverte et l'état de la pièce
            $table->timestamp('discovery_date')->nullable();
            $table->enum('piece_condition', array_column(PieceCondition::cases(), 'value'))->nullable();
            $table->text('condition_details')->nullable(); // Détails supplémentaires sur l'état
            
            // Champs pour la localisation du dépôt
            $table->string('deposit_location')->nullable();
            $table->string('deposit_city')->nullable();
            $table->string('deposit_district')->nullable(); // Quartier
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('thefinds', function (Blueprint $table) {
            $table->dropColumn([
                'is_anonymous',
                'contact_person',
                'pickup_hours',
                'special_instructions',
                'discovery_date',
                'piece_condition',
                'condition_details',
                'deposit_location',
                'deposit_city',
                'deposit_district'
            ]);
        });
    }
};