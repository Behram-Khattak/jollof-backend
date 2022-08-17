<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnboardingFlowsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('onboarding_flows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id');
            $table->boolean('profile')->default(false);
            $table->boolean('kyc')->default(false);
            $table->boolean('locations')->default(false);
            $table->boolean('teams')->default(false);
            $table->boolean('logo')->default(false);
            $table->boolean('banner')->default(false);
            $table->boolean('completed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('onboarding_flows');
    }
}
