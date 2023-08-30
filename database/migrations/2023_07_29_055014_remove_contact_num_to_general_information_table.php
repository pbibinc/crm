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
            $table->dropColumn('contact_num');
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
            $table->bigInteger('contact_num')->after('sub_out')->nullable();
        });
    }
};