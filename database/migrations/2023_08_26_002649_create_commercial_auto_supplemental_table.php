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
        Schema::create('commercial_auto_supplemental_table', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commercial_auto_id')->constrained('commercial_auto_table');
            $table->boolean('vehicle_maintenance_program');
            $table->boolean('is_vehicle_customized');
            $table->boolean('is_vehicle_owned_by_prospect');
            $table->boolean('declined_canceled_nonrenew_policy');
            $table->boolean('prospect_loss');
            $table->boolean('vehicle_use_for_towing');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commercial_auto_supplemental_table');
    }
};
