<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodExtrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_extras', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price');
            $table->unsignedInteger('limit')->default(1);
            $table->foreignId('category_id')->onDelete('cascade')->onUpdate('cascade')->constrained('food_categories');
            $table->boolean('active')->default(1);
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
        Schema::dropIfExists('food_extras');
    }
}
