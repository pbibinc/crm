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
            $table->dropColumn('remarks');
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
            $table->string('remarks')->after('each_employee')->nullable();
        });
    }
};