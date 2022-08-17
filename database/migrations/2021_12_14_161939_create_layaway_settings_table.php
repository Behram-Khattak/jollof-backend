<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLayawaySettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('layaway_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('service_fee')->default(1500);
            $table->integer('down_percentage')->default(30);
            $table->integer('cancellation_fee')->default(2500);
            $table->integer('price_limit')->default(5000);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('layaway_settings');
    }
}
