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
        Schema::table('bound_information_table', function (Blueprint $table) {
            //
            $table->string('status')->default('direct new')->after('user_profile_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bound_information_table', function (Blueprint $table) {
            //
            $table->dropColumn('status');
        });
    }
};