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
        Schema::create('general_liability_facilities_table', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('general_liabilities_id');
            $table->index('general_liabilities_id', 'gen_liabilities_id_index');

            $table->foreign('general_liabilities_id', 'gen_liabilities_id_foreign')->references('id')->on('general_liabilities_table')->onDelete('cascade');

            $table->unsignedBigInteger('recreational_facilities_id');
            $table->index('recreational_facilities_id', 'rec_facilities_id_index');

            $table->foreign('recreational_facilities_id', 'rec_facilities_id_foreign')->references('id')->on('recreational_facilities')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('general_liability_facilities_table');
    }
};