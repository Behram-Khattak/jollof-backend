<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLayawaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('layaways', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id');
            $table->foreignId('user_id');
            $table->string('amount_paid');
            $table->string('balance');
            $table->boolean('completed');
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
        Schema::dropIfExists('layaways');
    }
}
