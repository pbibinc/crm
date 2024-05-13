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
            $table->boolean('is_claims_made')->default(false)->after('is_subr_wvd');
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
            $table->dropColumn('is_claims_made');
        });
    }
};