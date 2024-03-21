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
            $table->foreignId('quote_comparison_id')->after('financing_company_id')->constrained('quote_comparison_table');
            $table->dropForeign(['policy_details_id']);
            $table->dropColumn('policy_details_id');
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
            $table->dropForeign(['quote_comparison_id']);
            $table->dropColumn('quote_comparison_id');
            $table->foreignId('policy_details_id')->after('financing_company_id')->constrained('policy_details_table');
        });
    }
};