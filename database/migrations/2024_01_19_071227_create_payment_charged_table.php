<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_charged_table', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_information_id')->constrained('payment_information_table');
            $table->foreignId('user_profile_id')->constrained('user_profiles');
            $table->string('invoice_number');
            $table->date('charged_date');
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
        Schema::dropIfExists('payment_charged_table');
    }
};