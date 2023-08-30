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
        Schema::table('workers_compensation_table', function (Blueprint $table) {
            $table->boolean('is_owners_payroll_included')->after('general_information_id')->nullable();
            $table->bigInteger('payroll_amount')->after('is_owners_payroll_included')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('workers_compensation_table', function (Blueprint $table) {
            $table->dropColumn('is_owners_payroll_included');
            $table->dropColumn('payroll_amount');
        });
    }
};