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
        Schema::create('have_losses_table', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads');
            $table->integer('product');
            $table->integer('losses')->default(0);
            $table->timestamp('date_of_claim');
            $table->string('loss_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('have_losses_table');
    }
};
