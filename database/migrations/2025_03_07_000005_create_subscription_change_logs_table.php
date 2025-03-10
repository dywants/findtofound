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
        Schema::create('subscription_change_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_subscription_id')->nullable()->constrained('user_subscriptions')->onDelete('set null');
            $table->foreignId('previous_plan_id')->nullable()->constrained('subscription_plans')->onDelete('set null');
            $table->foreignId('new_plan_id')->nullable()->constrained('subscription_plans')->onDelete('set null');
            $table->string('change_type'); // 'upgrade', 'downgrade', 'renewal', 'cancellation', 'reactivation'
            $table->text('reason')->nullable();
            $table->json('details')->nullable();
            $table->foreignId('changed_by_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            // Index pour optimiser les requêtes fréquentes
            $table->index(['user_id', 'change_type']);
            $table->index(['user_subscription_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_change_logs');
    }
};
