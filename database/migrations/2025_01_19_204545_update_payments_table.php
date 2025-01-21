<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            // Modification des colonnes existantes
            $table->renameColumn('paymentSource', 'payment_source');
            
            // Ajout des nouvelles colonnes
            $table->string('transaction_id')->nullable()->after('payment_status');
            $table->json('payment_details')->nullable()->after('transaction_id');
            $table->timestamp('paid_at')->nullable()->after('payment_details');

            // Ajout des contraintes de clés étrangères
            $table->foreign('user_payer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('thefind_id')->references('id')->on('thefinds')->onDelete('cascade');

            // Ajout des index
            $table->index('payment_status');
            $table->index('payment_source');
            $table->index(['user_payer_id', 'payment_status']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            // Suppression des index
            $table->dropIndex(['payment_status']);
            $table->dropIndex(['payment_source']);
            $table->dropIndex(['user_payer_id', 'payment_status']);

            // Suppression des clés étrangères
            $table->dropForeign(['user_payer_id']);
            $table->dropForeign(['thefind_id']);

            // Suppression des colonnes
            $table->dropColumn(['transaction_id', 'payment_details', 'paid_at']);
            
            // Retour au nom original de la colonne
            $table->renameColumn('payment_source', 'paymentSource');
        });
    }
}
