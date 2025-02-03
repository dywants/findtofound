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
        Schema::table('thefinds', function (Blueprint $table) {
            $table->boolean('is_anonymous')->default(false)->after('amount_check');
            $table->text('localisation')->nullable()->after('is_anonymous');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('thefinds', function (Blueprint $table) {
            $table->dropColumn(['is_anonymous', 'localisation']);
        });
    }
};
