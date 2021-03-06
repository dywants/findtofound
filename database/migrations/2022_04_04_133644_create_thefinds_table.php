<?php

use App\Models\Piece;
use App\Models\User;
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
        Schema::create('thefinds', function (Blueprint $table) {
            $table->id();
            $table->string('fullName');
            $table->string('findCity');
            $table->string('ward')->nullable();
            $table->text('details')->nullable();
            $table->string('photos');
            $table->boolean('approval_status')->default(0);
            $table->foreignIdFor(User::class)->nullable()->constrained();
            $table->text('geo_lieu')->nullable();
            $table->foreignIdFor(Piece::class)->constrained();
            $table->decimal('amount_check');
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
        Schema::dropIfExists('thefinds');
    }
};
