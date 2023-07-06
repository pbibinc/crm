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
        Schema::table('leads_user_profile', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('current_user_id')->after('user_profile_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leads_user_profile', function (Blueprint $table) {
            //
            $table->dropColumn('current_user_id');
        });
    }
};
