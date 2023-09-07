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
        Schema::create('builder_risk_table', function (Blueprint $table) {
            $table->id();
            $table->foreignId('general_information_id')->constrained('general_information_table');
            $table->string('property_address');
            $table->string('value_of_structure');
            $table->string('value_of_work');
            $table->boolean('has_project_started');
            $table->timestamp('project_started_date');
            $table->boolean('construction_status');
            $table->string('construction_type');
            $table->string('protection_class');
            $table->string('square_footage');
            $table->string('number_floors');
            $table->string('number_dwelling');
            $table->string('jobsite_security');
            $table->string('firehydrant_distance');
            $table->string('firestation_distance');
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
        Schema::dropIfExists('builder_risk_table');
    }
};
