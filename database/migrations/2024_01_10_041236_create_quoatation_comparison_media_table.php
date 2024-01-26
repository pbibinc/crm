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
        Schema::create('quoatation_comparison_media_table', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quote_comparison_id')->constrained('quote_comparison_table');
            $table->foreignId('metadata_id')->constrained('metadata');
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
        Schema::dropIfExists('quoatation_comparison_media_table');
    }
};
