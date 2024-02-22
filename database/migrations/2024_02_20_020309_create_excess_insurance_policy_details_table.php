<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        Schema::create('excess_insurance_policy_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('policy_details_id')->constrained('policy_details_table');
            $table->boolean('is_umbrella_liability')->default(false);
            $table->boolean('is_excess_liability')->default(false);
            $table->boolean('is_occur')->default(false);
            $table->boolean('is_claims_made')->default(false);
            $table->boolean('is_ded')->default(false);
            $table->boolean('is_retention')->default(false);
            $table->boolean('is_addl_insd')->default(false);
            $table->boolean('is_subr_wvd')->default(false);
            $table->string('each_occurrence');
            $table->string('aggregate');
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
        Schema::dropIfExists('excess_insurance_policy_details');
    }
};
