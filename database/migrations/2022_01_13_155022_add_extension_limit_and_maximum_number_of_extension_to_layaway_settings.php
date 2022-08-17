<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtensionLimitAndMaximumNumberOfExtensionToLayawaySettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('layaway_settings', function (Blueprint $table) {
            $table->integer('extension_limit')->default(1);
            $table->integer('number_of_extension')->default(2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('layaway_settings', function (Blueprint $table) {
            //
        });
    }
}
