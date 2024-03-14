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
        Schema::create('financing_agreement', function (Blueprint $table) {
            $table->id();
            $table->foreignId('policy_details_id')->constrained('policy_details_table');
            $table->foreignId('financing_company_id')->constrained('financing_company');
            $table->boolean('is_auto_pay')->default(false);
            $table->integer('due_date')->nullable();
            $table->date('payment_start');
            $table->string('monthly_payment');
            $table->foreignId('media_id')->nullable()->constrained('metadata');
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
        Schema::dropIfExists('financing_agreement');
    }
};