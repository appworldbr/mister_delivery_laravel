<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodExtraFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_extra_favorites', function (Blueprint $table) {
            $table->foreignId('food_favorite_id')->onUpdate('cascade')->onDelete('cascade')->constrained();
            $table->foreignId('food_extra_id')->onUpdate('cascade')->onDelete('cascade')->constrained();
            $table->primary(['food_favorite_id', 'food_extra_id']);
            $table->unsignedInteger('quantity')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('food_extra_favorites');
    }
}
