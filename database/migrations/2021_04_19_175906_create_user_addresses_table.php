<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 127);
            $table->string('zip', 20);
            $table->string('state', 2);
            $table->string('city', 100);
            $table->string('district', 127);
            $table->string('address', 127);
            $table->string('number', 127);
            $table->text('complement', 127)->nullable();
            $table->boolean('is_default')->default(0);
            $table->foreignId('user_id')->constrained()->onUpdate("cascade")->onDelete("cascade");
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
        Schema::dropIfExists('user_addresses');
    }
}
