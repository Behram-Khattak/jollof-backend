<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFashionProductMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('fashion_product_materials', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('fashion_product_materials');
    }
}
