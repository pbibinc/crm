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
        Schema::create('general_liabilities_policy_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('policy_details_id')->constrained('policy_details_table');
            $table->boolean('is_commercial_gl')->default(false);
            $table->boolean('is_occur')->default(false);
            $table->boolean('is_policy')->default(false);
            $table->boolean('is_project')->default(false);
            $table->boolean('is_loc')->default(false);
            $table->boolean('is_additional_insd')->default(false);
            $table->boolean('is_subr_wvd')->default(false);
            $table->string('each_occurence');
            $table->string('damage_to_rented');
            $table->string('medical_expenses');
            $table->string('per_adv_injury');
            $table->string('gen_aggregate');
            $table->string('product_comp');
            $table->date('effective_date');
            $table->date('expiry_date');
            $table->string('status')->default('binding');
            $table->foreignId('media_id')->constrainted('media');
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
        Schema::dropIfExists('general_liabilities_policy_details');
    }
};
