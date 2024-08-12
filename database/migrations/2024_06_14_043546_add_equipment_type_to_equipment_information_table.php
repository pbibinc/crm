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
        Schema::table('equipment_information_table', function (Blueprint $table) {
            //
            $table->string('equipment_type')->after('tools_equipment_id')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('equipment_information_table', function (Blueprint $table) {
            //
            $table->dropColumn('equipment_type');
        });
    }
};
