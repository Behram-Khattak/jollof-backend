<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuisineCategoryTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('cuisine_category', function (Blueprint $table) {
            $table->id();
            $table->integer('restaurant_id');
            $table->string('name');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('cuisine_category');
    }
}
