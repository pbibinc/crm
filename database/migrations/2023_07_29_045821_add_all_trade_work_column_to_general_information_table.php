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
            $table->string('all_trade_work')->after('employee_payroll')->nullable();
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
            $table->dropColumn('all_trade_work');
        });
    }
};