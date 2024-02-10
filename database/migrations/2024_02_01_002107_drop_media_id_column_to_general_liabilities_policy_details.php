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
        Schema::table('general_liabilities_policy_details', function (Blueprint $table) {
            //

            $table->dropColumn('media_id');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('general_liabilities_policy_details', function (Blueprint $table) {
            //
            $table->integer('media_id')->unsigned()->nullable()->after('status');
        });
    }
};