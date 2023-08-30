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
        Schema::create('general_information_table', function (Blueprint $table) {
            $table->id();
            $table->foreignId('leads_id')->constrained('leads');
            $table->string('firstname');
            $table->string('lastname');
            $table->integer('contact_num');
            $table->integer('alt_num');
            $table->string('email_address');
            $table->integer('fax');
            $table->string('website');
            $table->integer('gross_receipt');
            $table->integer('full_time_employee');
            $table->integer('part_time_employee');
            $table->integer('employee_payroll');
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
        Schema::dropIfExists('general_information_table');
    }
};