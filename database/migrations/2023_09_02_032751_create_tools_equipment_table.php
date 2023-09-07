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
        Schema::create('tools_equipment_table', function (Blueprint $table) {
            $table->id();
            $table->foreignId('general_information_id')->constrained('general_information_table');
            $table->string('misc_tools_amount');
            $table->string('rented_less_equipment');
            $table->string('scheduled_equipment');
            $table->string('deductible_amount');
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
        Schema::dropIfExists('tools_equipment_table');
    }
};
