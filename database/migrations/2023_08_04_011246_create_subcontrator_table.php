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
        Schema::create('subcontractor_table', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('general_liabilities_id')->index();
            $table->foreign('general_liabilities_id')->references('id')->on('general_liabilities_table')->onDelete('cascade');

            $table->boolean('blasting_operation');
            $table->boolean('hazardous_waste');
            $table->boolean('asbestos_mold');
            $table->boolean('three_stories_height');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subcontrator_table');
    }
};