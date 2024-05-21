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
        Schema::table('financing_status', function (Blueprint $table) {
            $table->foreignId('selected_quote_id')->nullable()->constrained('selected_quote')->after('quotation_product_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('financing_status', function (Blueprint $table) {
            $table->dropForeign(['selected_quote_id']);
            $table->dropColumn('selected_quote_id');
        });
    }
};