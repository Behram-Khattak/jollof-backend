<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuisineMenusTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('cuisine_menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id');
            $table->foreignId('cuisine_category_id');
            $table->string('type');
            $table->string('menu');
            $table->string('description');
            $table->string('delivery_time');
            $table->string('price');
            $table->string('sales_price')->nullable();
            $table->timestamp('sales_start')->nullable();
            $table->timestamp('sales_end')->nullable();
            $table->text('toppings')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('cuisine_menus');
    }
}
