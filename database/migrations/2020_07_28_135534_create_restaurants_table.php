<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained('businesses')->onDelete('cascade');
            $table->bigInteger('business_location_id')->nullable();
            $table->string('min_order')->nullable();
            $table->string('disposable')->nullable();
            $table->text('delivery_fee')->nullable();
            $table->string('delivery_time')->nullable();
            $table->string('delivery_options')->nullable();
            $table->string('payment_types')->nullable();
            $table->string('featured')->nullable();
            $table->text('hours')->nullable();
            $table->string('default_setup')->default(0);
            $table->string('status')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('restuarants');
    }
}
