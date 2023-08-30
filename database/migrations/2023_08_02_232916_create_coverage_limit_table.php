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
        Schema::create('coverage_limit_table', function (Blueprint $table) {
            $table->id();
            $table->string('limit');
            $table->string('medical');
            $table->string('fire_damage');
            $table->string('deductible');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coverage_limit_table');
    }
};