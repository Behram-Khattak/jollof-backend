<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('microsite')->nullable();
            $table->string('slot')->nullable();
            $table->string('file_url')->nullable();
            $table->string('link')->nullable();
            $table->string('location')->nullable();
            $table->integer('days')->nullable();
            $table->string('banner_type');
            $table->string('can_view');
            $table->dateTime('start_date', 0);
            $table->dateTime('expiry_date', 0);
            $table->string('price')->nullable();
            $table->enum('status', ['active', 'inactive']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('banners');
    }
}
