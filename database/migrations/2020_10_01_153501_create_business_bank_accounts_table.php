<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessBankAccountsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('business_bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_id')->constrained('banks');
            $table->foreignId('business_id')->constrained('businesses');
            $table->string('account_name', 100);
            $table->string('account_number', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('business_bank_accounts');
    }
}
