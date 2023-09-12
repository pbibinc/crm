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
        Schema::create('business_owners_policy_table', function (Blueprint $table) {
            $table->id();
            $table->foreignId('general_information_id')->constrained('general_information_table');
            $table->string('property_address');
            $table->string('loss_payee_information');
            $table->string('building_industry');
            $table->string('occupancy');
            $table->string('building_cost');
            $table->string('business_property_limit');
            $table->string('building_construction_type');
            $table->string('year_built');
            $table->string('square_footage');
            $table->string('floor_number');
            $table->string('automatic_sprinkler_system');
            $table->string('automatic_fire_alarm');
            $table->string('nereast_fire_hydrant');
            $table->string('nearest_fire_station');
            $table->string('commercial_coocking_system');
            $table->string('automatic_bulgar_alarm');
            $table->string('security_camera');
            $table->string('last_update_roofing');
            $table->string('last_update_heating');
            $table->string('last_update_plumbing');
            $table->string('last_update_electrical');
            $table->string('amount_policy');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('business_owners_policy_table');
    }
};
