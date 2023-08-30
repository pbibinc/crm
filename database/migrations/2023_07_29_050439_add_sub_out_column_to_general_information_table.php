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
            $table->bigInteger('sub_out')->after('all_trade_work')->nullable();
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
            $table->dropColumn('sub_out');
        });
    }
};