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
        Schema::create('workers_compensation_table', function (Blueprint $table) {
            $table->id();
            $table->foreignId('general_information_id')->constrained('general_information_table')->onDelete('cascade');
            $table->string('specific_employee_description');
            $table->bigInteger('fein_number');
            $table->bigInteger('ssin_number');
            $table->timestamp('expiration');
            $table->string('prior_carrier');
            $table->bigInteger('workers_compensation_amount');
            $table->bigInteger('policy_limit');
            $table->bigInteger('each_accident');
            $table->bigInteger('each_employee');
            $table->string('remarks');
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
        Schema::dropIfExists('workers_compensation_table');
    }
};