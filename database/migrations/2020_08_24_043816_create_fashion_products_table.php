<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFashionProductsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('fashion_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained('businesses');
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('material_id');
            $table->foreignId('color_id');
            $table->foreignId('size_type_id')->nullable();
            $table->foreignId('size_value_id')->nullable();
            $table->string('name', 100);
            $table->string('slug');
            $table->string('description', 250);
            $table->unsignedInteger('quantity');
            $table->unsignedDecimal('price', 9, 2);
            $table->unsignedDecimal('sales_price', 9, 2)->nullable();
            $table->float('weight', 10, 4)->unsigned()->nullable();
            $table->string('sku', 20);
            $table->boolean('is_available');
            $table->timestamp('sales_start')->nullable();
            $table->timestamp('sales_end')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('fashion_products');
    }
}
