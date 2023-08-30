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
        Schema::create('vehicle_information_table', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commercial_auto_id')->constrained('commercial_auto_table');
            $table->string('year');
            $table->string('make');
            $table->string('model');
            $table->string('vin');
            $table->string('radius_miles');
            $table->string('cost_new_vehicle');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_information_table');
    }
};
