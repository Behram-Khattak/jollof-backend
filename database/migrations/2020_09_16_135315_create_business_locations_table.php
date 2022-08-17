<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessLocationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('business_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained('businesses', 'id');
            $table->string('telephone', 30)->nullable();
            $table->string('whatsapp', 30)->nullable();
            $table->string('state');
            $table->string('city');
            $table->string('area')->nullable();
            $table->string('address');
            $table->boolean('default')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('business_locations');
    }
}
