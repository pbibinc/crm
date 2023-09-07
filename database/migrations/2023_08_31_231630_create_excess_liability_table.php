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
        Schema::create('excess_liability_table', function (Blueprint $table) {
            $table->id();
            $table->foreignId('general_information_id')->constrained('general_information_table');
            $table->string('excess_limit');
            $table->timestamp('excess_date')->nullable();
            $table->string('insurance_carrier');
            $table->string('policy_number');
            $table->string('policy_premium');
            $table->timestamp('general_liability_effective_date')->nullable();
            $table->timestamp('general_liability_expiration_date')->nullable();
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
        Schema::dropIfExists('excess_liability_table');
    }
};
