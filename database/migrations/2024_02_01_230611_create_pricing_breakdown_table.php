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
        Schema::create('pricing_breakdown_table', function (Blueprint $table) {
            $table->id();
            $table->string('premium')->nullable();
            $table->string('endorsements')->nullable();
            $table->string('policy_fee')->nullable();
            $table->string('inspection_fee')->nullable();
            $table->string('stamping_fee')->nullable();
            $table->string('surplus_lines_tax')->nullable();
            $table->string('placement_fee')->nullable();
            $table->string('broker_fee')->nullable();
            $table->string('miscellaneous_fee')->nullable();
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
        Schema::dropIfExists('pricing_breakdown_table');
    }
};