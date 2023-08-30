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
        Schema::create('workers_comp_have_losses_table', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workers_compensation_id')->constrained('workers_compensation_table')->onDelete('cascade');
            $table->timestamp('date_of_claim');
            $table->bigInteger('loss_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workers_comp_have_losses_table');
    }
};