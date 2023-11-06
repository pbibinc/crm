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
        Schema::create('general_liabilities_have_losses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('general_liabilities_id')->constrained('general_liabilities_table');
            $table->timestamp('date_of_claim');
            $table->string('loss_amount');
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
        Schema::dropIfExists('general_liabilities_have_losses');
    }
};