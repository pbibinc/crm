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

        Schema::table('general_liabilities_table', function (Blueprint $table) {
               //
           $table->boolean('is_office_home')->after('contract_license_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('general_liabilities_table', function (Blueprint $table) {
            //
            $table->dropColumn('is_office_home');
        });
    }
};