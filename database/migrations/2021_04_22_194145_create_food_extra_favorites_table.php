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
            $table->foreignId('favorite_id')->constrained('food_favorites')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('extra_id')->constrained('food_extras')->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['favorite_id', 'extra_id']);
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
