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
        Schema::create('classcode_per_employee_table', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workers_compensation_id')->constrained('workers_compensation_table')->onDelete('cascade');
            $table->string('employee_description');
            $table->bigInteger('number_of_employee');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classcode_per_employee_table');
    }
};