<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentColumnsToThefoundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('thefounds', function (Blueprint $table) {
            if (!Schema::hasColumn('thefounds', 'payment_status')) {
                $table->string('payment_status')->default('pending')->after('amount');
            }
            if (!Schema::hasColumn('thefounds', 'payment_id')) {
                $table->string('payment_id')->nullable()->after('payment_status');
            }
            if (!Schema::hasColumn('thefounds', 'paid_at')) {
                $table->timestamp('paid_at')->nullable()->after('payment_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('thefounds', function (Blueprint $table) {
            $table->dropColumn(['payment_status', 'payment_id', 'paid_at']);
        });
    }
}
