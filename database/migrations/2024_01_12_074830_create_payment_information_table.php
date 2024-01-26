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
        Schema::create('payment_information_table', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quote_comparison_id')->constrained('quote_comparison_table');
            $table->string('payment_type');
            $table->string('payment_method');
            $table->string('compliance_by');
            $table->string('amount_to_charged');
            $table->string('note');
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
        Schema::dropIfExists('payment_information_table');
    }
};
