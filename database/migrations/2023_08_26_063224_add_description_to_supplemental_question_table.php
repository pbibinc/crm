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
        Schema::table('commercial_auto_supplemental_table', function (Blueprint $table) {
            //
            $table->string('vehicle_maintenace_description')->after('vehicle_maintenance_program')->nullable();
            $table->string('vehicle_customized_description')->after('is_vehicle_customized')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('commercial_auto_supplemental_table', function (Blueprint $table) {
            //
            $table->dropColumn('vehicle_maintenace_description');
            $table->dropColumn('vehicle_customized_description');
        });
    }
};
