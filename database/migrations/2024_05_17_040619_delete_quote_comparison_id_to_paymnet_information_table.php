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
        Schema::table('payment_information_table', function (Blueprint $table) {
            //
            $table->dropForeign(['quote_comparison_id']);
            $table->dropColumn('quote_comparison_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_information_table', function (Blueprint $table) {
            $table->foreignId('quote_comparison_id')->nullable()->after('id')->constrained('quote_comparison_table');
        });
    }
};
