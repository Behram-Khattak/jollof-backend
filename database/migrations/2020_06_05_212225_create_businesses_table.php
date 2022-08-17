<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->nullable()->constrained('users', 'id')->onDelete('cascade');
            $table->foreignId('manager_id')->nullable()->constrained('users', 'id')->onDelete('cascade');
            $table->foreignId('business_type_id')->constrained('business_types', 'id')->onDelete('cascade');
            $table->string('name');
            $table->string('slug');
            $table->string('email');
            $table->string('telephone', 30)->nullable();
            $table->string('whatsapp', 30)->nullable();
            $table->string('category', 30)->nullable();
            $table->string('status', 20)->default(\App\Enums\BusinessStates::PENDING);
            $table->boolean('kyc_upload')->default(false);
            $table->text('description');
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('businesses');
    }
}
