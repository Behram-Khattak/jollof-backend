<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('code')->nullable();
            $table->string('period')->nullable();
            $table->timestamp('start')->nullable();
            $table->timestamp('expire')->nullable();
            $table->string('percentage')->nullable();
            $table->string('site')->nullable();
            $table->string('type')->nullable();
            $table->string('type_value')->nullable();
            $table->string('status')->default('active');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
