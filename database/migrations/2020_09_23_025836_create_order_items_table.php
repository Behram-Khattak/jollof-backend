<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->unsignedBigInteger('business_id')->nullable();
            $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->integer('quantity')->nullable()->default(0);
            $table->double('unit_price');
            $table->double('total_price');
            $table->string('duration')->nullable();
            $table->string('status');
            $table->timestamp('process_timestamp')->nullable();
            $table->timestamp('pickup_timestamp')->nullable();
            $table->timestamp('delivery_timestamp')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
