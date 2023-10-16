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
        Schema::table('quotation_product_table', function (Blueprint $table) {
            //
            $table->dateTime('callback_date')->nullable()->after('sent_out_date');
        });
    }

    /**
     * Reverse the migrations.br
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quotation_product_table', function (Blueprint $table) {
            //
            $table->dropColumn('callback_date');
        });
    }
};
