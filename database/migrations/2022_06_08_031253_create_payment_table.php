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
            $table->foreignId('user_payer_id')->constrained('users')->onDelete('cascade');
            $table->string('order_id')->unique()->nullable();
            $table->foreignId('thefind_id')->constrained('thefinds')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->string('currency');
            $table->string('payment_source');  
            $table->string('payment_status');
            $table->string('transaction_id')->nullable();  
            $table->json('payment_details')->nullable();   
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('payments');  
    }
};
