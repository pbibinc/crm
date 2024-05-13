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
            $table->foreignId('selected_quote_id')->contrained('selected_quote')->after('id')->nullable();
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
            $table->dropColumn('selected_quote_id');
        });
    }
};
