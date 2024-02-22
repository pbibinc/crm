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
        Schema::create('commercial_auto_policy_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('policy_details_id')->constrained('policy_details_table');
            $table->boolean('is_any_auto');
            $table->boolean('is_owned_auto');
            $table->boolean('is_scheduled_auto');
            $table->boolean('is_hired_auto');
            $table->boolean('is_non_owned_auto');
            $table->boolean('is_addl_insd');
            $table->boolean('is_subr_wvd');
            $table->string('combined_single_unit');
            $table->string('bi_per_person');
            $table->string('bi_per_accident');
            $table->string('property_damage');
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
        Schema::dropIfExists('commercial_auto_policy_detail');
    }
};