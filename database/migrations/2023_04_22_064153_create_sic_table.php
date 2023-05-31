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
        Schema::create('standard_industrial_classification', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sic_classcode')->constrained('class_codes');
            $table->string('sic_code', 255)->nullable();
            $table->string('workers_comp_code', 255)->nullable();
            $table->longText('description')->nullable();
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
        Schema::dropIfExists('standard_industrial_classification');
    }
};
