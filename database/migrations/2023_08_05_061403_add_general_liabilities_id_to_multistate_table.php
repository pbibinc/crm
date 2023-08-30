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
        Schema::table('multistate_table', function (Blueprint $table) {
            //
            $table->foreignId('general_liabilities_id')->after('id')->constrained('general_liabilities_table')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('multistate_table', function (Blueprint $table) {
            //
            $table->dropForeign(['general_liabilities_id']);
            $table->dropColumn('general_liabilities_id');
        });
    }
};