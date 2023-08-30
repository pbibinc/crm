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
        Schema::table('workers_compensation_table', function (Blueprint $table) {
            //
            $table->string('fein_number')->change();
            $table->string('ssin_number')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('workers_compensation_table', function (Blueprint $table) {
            //
            $table->bigInteger('fein_number')->change();
            $table->bigInteger('ssin_number')->change();
        });
    }
};