<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->onUpdate('cascade')->onDelete('cascade')->constrained();
            $table->foreignId('food_id')->onUpdate('cascade')->onDelete('cascade')->constrained();
            $table->text('observation')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('food_favorites');
    }
}
