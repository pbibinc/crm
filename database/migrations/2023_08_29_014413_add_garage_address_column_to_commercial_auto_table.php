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
        Schema::table('commercial_auto_table', function (Blueprint $table) {
            //
            $table->string('garage_address')->after('ssn')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('commercial_auto_table', function (Blueprint $table) {
            //
            $table->dropColumn('garage_address');
        });
    }
};
