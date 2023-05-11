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
        Schema::create('general_information', function (Blueprint $table) {
            $table->id();
            $table->foreignId('leads_id')->constrained('leads');
            $table->string('firstname', 255);
            $table->string('lastname', 255);
            $table->string('job_position', 255);
            $table->bigInteger('contact_number')->nullable();
            $table->bigInteger('alt_number')->nullable();
            $table->bigInteger('fax')->nullable();
            $table->string('website')->nullable();
            $table->integer('gross_receipt',)->nullable();
            $table->integer('full_item_employee')->nullable();
            $table->integer('part_time_employee')->nullable();
            $table->integer('employee_payroll')->nullable();
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
        Schema::dropIfExists('general_information');
    }
};
