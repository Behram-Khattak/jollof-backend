<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_type_id')->nullable()->constrained('business_types');
            $table->foreignId('parent_id')->nullable()->constrained('categories');
            $table->string('name');
            $table->string('slug');
            $table->timestamps();

            $table->unique(['business_type_id', 'parent_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
