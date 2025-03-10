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
        Schema::create('usage_trackings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_subscription_id')->nullable()->constrained('user_subscriptions')->onDelete('set null');
            $table->string('feature_type'); // 'document_generation', 'document_storage', etc.
            $table->integer('count')->default(0);
            $table->timestamp('reset_at')->nullable();
            $table->json('details')->nullable();
            $table->timestamps();

            // Index pour optimiser les requêtes fréquentes
            $table->index(['user_id', 'feature_type']);
            $table->index(['user_subscription_id', 'feature_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usage_trackings');
    }
};
