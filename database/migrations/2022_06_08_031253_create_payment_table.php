<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type_piece')->nullable();
            $table->unsignedBigInteger('user_payer_id');
            $table->string('order_id')->nullable();
            $table->unsignedBigInteger('thefind_id');
            $table->double('amount', 10, 2);
            $table->string('currency');
            $table->string('paymentSource');
            $table->string('payment_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment');
    }
};
