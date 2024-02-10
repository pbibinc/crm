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
            $table->renameColumn('credit_type', 'payment_term');
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
            //
            $table->renameColumn('payment_term', 'credit_type');
        });
    }
};