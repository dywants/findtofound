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
        Schema::create('user_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('subscription_plan_id')->constrained('subscription_plans');
            $table->timestamp('starts_at');
            $table->timestamp('ends_at')->nullable();
            $table->string('billing_cycle')->default('monthly'); // 'monthly' ou 'yearly'
            $table->string('status')->default('pending'); // 'active', 'canceled', 'expired', 'pending'
            $table->boolean('auto_renew')->default(true);
            $table->text('cancellation_reason')->nullable();
            $table->string('payment_method')->nullable();
            $table->foreignId('last_payment_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_subscriptions');
    }
};
