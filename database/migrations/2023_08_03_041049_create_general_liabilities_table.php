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
        Schema::create('general_liabilities_table', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('general_information_id')->index();
            $table->foreign('general_information_id')->references('id')->on('general_information_table')->onDelete('cascade');
            $table->text('business_description');
            $table->decimal('residential', 5, 2);
            $table->decimal('commercial', 5, 2);
            $table->decimal('new_construction', 5, 2);
            $table->decimal('repair', 5, 2);
            $table->boolean('self_perform_roofing');
            $table->boolean('concrete_foundation_work');
            $table->boolean('perform_track_work');
            $table->boolean('is_condo_townhouse');
            $table->boolean('perform_multi_dwelling');
            $table->string('business_entity')->nullable();
            $table->unsignedSmallInteger('years_in_business');
            $table->unsignedSmallInteger('years_in_professional');
            $table->string('largest_project', 255)->nullable();
            $table->string('largest_project_amount', 255)->nullable();
            $table->string('contract_license', 255)->nullable();
            $table->string('contract_license_name', 255)->nullable();
            $table->timestamp('expiration_of_general_liabilities')->nullable();
            $table->unsignedInteger('policy_premium')->nullable();
            $table->unsignedBigInteger('coverage_limit_id')->index();
            $table->foreign('coverage_limit_id')->references('id')->on('coverage_limit_table')->onDelete('cascade');
            $table->string('cross_sell', 255)->nullable();
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
        Schema::dropIfExists('general_liabilities_table');
    }
};