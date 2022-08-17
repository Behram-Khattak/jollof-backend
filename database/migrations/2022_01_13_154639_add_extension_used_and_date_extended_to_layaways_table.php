<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtensionUsedAndDateExtendedToLayawaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('layaways', function (Blueprint $table) {
            $table->integer('extension_used')->default(0);
            $table->date('date_extended')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('layaways', function (Blueprint $table) {
            //
        });
    }
}
