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
        Schema::table('general_information_table', function (Blueprint $table) {
            //
            $table->bigInteger('alt_num')->change();
            $table->bigInteger('fax')->change();
            $table->bigInteger('full_time_employee')->change();
            $table->bigInteger('part_time_employee')->change();
            $table->bigInteger('employee_payroll')->change();
            $table->bigInteger('sub_out')->change();
            $table->bigInteger('gross_receipt')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('general_information_table', function (Blueprint $table) {
            //
            $table->integer('alt_num')->change();
            $table->integer('fax')->change();
            $table->integer('full_time_employee')->change();
            $table->integer('part_time_employee')->change();
            $table->integer('employee_payroll')->change();
            $table->integer('sub_out')->change();
            $table->integer('gross_receipt')->change();
        });
    }
};
