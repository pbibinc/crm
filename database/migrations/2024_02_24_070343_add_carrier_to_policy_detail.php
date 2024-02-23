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
        Schema::table('policy_details_table', function (Blueprint $table) {
            //
            $table->string('carrier')->nullable()->after('policy_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('policy_details_table', function (Blueprint $table) {
            //
            $table->dropColumn('carrier');
        });
    }
};