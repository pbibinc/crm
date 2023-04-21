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
        Schema::create('sic_table', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classcode_id')->constrained('class_codes')->onDelete('cascade');
            $table->text('sic_code');
            $table->longText('workers_comp_code');
            $table->longText('description');
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
        Schema::dropIfExists('sic_table');
    }
};
