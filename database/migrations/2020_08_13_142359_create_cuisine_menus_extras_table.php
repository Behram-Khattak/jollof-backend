<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuisineMenusExtrasTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('cuisine_menus_extras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cuisine_menus_id');
            $table->foreignId('consumables_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('cuisine_menus_extras');
    }
}
