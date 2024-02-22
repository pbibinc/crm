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
        Schema::create('payment_date', function (Blueprint $table) {
            $table->id();
            $table->foreignId('financing_agreement_id')->constrained('financing_agreement');
            $table->date('due_date');
            $table->date('date_paid')->nullable();
            $table->string('amount_due');
            $table->string('amount_paid')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_date');
    }
};