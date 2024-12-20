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
        Schema::table('quote_comparison_table', function (Blueprint $table) {
            //
            $table->integer('number_of_payments')->nullable()->after('monthly_payment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quote_comparison_table', function (Blueprint $table) {
            //
            $table->dropColumn('number_of_payments');
        });
    }
};