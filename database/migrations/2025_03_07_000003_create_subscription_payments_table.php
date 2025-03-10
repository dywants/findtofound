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
        Schema::create('subscription_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_subscription_id')->constrained('user_subscriptions')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('EUR');
            $table->string('payment_method')->nullable();
            $table->string('payment_provider')->nullable(); // 'stripe', 'paypal', etc.
            $table->string('transaction_id')->nullable();
            $table->string('invoice_id')->nullable();
            $table->string('status')->default('pending'); // 'pending', 'completed', 'failed', 'refunded'
            $table->json('payment_details')->nullable();
            $table->timestamp('billing_period_start')->nullable();
            $table->timestamp('billing_period_end')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });

        // Ajouter la contrainte de clé étrangère pour last_payment_id dans user_subscriptions
        Schema::table('user_subscriptions', function (Blueprint $table) {
            $table->foreign('last_payment_id')->references('id')->on('subscription_payments')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_subscriptions', function (Blueprint $table) {
            $table->dropForeign(['last_payment_id']);
        });
        
        Schema::dropIfExists('subscription_payments');
    }
};
