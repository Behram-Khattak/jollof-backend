<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubcategoryAndVariantToFashionProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fashion_products', function (Blueprint $table) {
            $table->string('subcategory_id')->nullable()->after('category_id');
            $table->string('variant_id')->nullable()->after('subcategory_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fashion_products', function (Blueprint $table) {
           
        });
    }
}
