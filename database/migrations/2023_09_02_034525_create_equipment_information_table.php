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
        Schema::create('equipment_information_table', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tools_equipment_id')->constrained('tools_equipment_table');
            $table->string('equipment');
            $table->string('year');
            $table->string('make');
            $table->string('model');
            $table->string('serial_identification_no');
            $table->string('value');
            $table->string('year_acquired');
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
        Schema::dropIfExists('equipment_information_table');
    }
};
