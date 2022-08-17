<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlutterwavesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('flutterwave', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->nullable();
            $table->string('reference')->nullable();
            $table->string('flutterwave_reference')->nullable();
            $table->string('email')->nullable();
            $table->integer('amount')->nullable();
            $table->string('status')->nullable();
            $table->string('gateway_response')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('card_type')->nullable();
            $table->integer('last4')->nullable();
            $table->string('narration')->nullable();
            $table->string('expiry', 10)->nullable();
            $table->string('bank')->nullable();
            $table->string('channel')->nullable();
            $table->string('authorization_code')->nullable();
            $table->longText('raw_response')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->string('verified')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('flutterwave');
    }
}
