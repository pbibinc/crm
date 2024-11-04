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
        Schema::table('financing_agreement', function (Blueprint $table) {
            //
            $table->string('down_payment')->default('$0.00')->after('monthly_payment');
            $table->string('amount_financed')->default('$0.00')->after('down_payment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('financing_agreement', function (Blueprint $table) {
            //
            $table->dropColumn('down_payment');
            $table->dropColumn('amount_financed');
        });
    }
};
