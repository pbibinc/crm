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
            $table->foreignId('selected_quote_id')->nullable()->after('id')->constrained('selected_quote');
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
            $table->dropForeign(['selected_quote_id']);
            $table->dropColumn('selected_quote_id');
        });
    }
};
