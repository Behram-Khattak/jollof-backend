<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_groups', function (Blueprint $table) {
            $table->id();
            $table->integer('microsite')->nullable();
            $table->bigInteger('state_id');
            $table->integer('area_id')->nullable();
            $table->integer('min_shipment_qty')->default(1);
            $table->integer('max_shipment_qty')->default(1);
            $table->float('shipment_price');
            $table->softDeletes();
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
        Schema::dropIfExists('shipping_groups');
    }
}
