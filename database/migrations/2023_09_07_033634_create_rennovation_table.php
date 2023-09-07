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
        Schema::create('rennovation_table', function (Blueprint $table) {
            $table->id();
            $table->foreignId('builders_risk_id')->constrained('builder_risk_table');
            $table->string('description');
            $table->string('last_update_roofing');
            $table->string('last_update_heating');
            $table->string('last_update_plumbing');
            $table->string('last_update_electrical');
            $table->string('stucture_occupied');
            $table->string('structure_built');
            $table->string('description_operation');
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
        Schema::dropIfExists('rennovation_table');
    }
};
