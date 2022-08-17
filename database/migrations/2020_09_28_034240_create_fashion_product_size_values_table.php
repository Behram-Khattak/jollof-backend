<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFashionProductSizeValuesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('fashion_product_size_values', function (Blueprint $table) {
            $table->id();
            $table->string('name', 20)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('fashion_product_size_values');
    }
}
