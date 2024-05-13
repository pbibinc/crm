s<?php

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
        Schema::create('selected_quote', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_product_id')->constrained('quotation_product_table');
            $table->foreignId('quotation_market_id')->constrained('quotation_market_table');
            $table->foreignId('pricing_breakdown_id')->nullable()->constrained('selected_pricing_breakdown');
            $table->string('quote_no');
            $table->string('full_payment');
            $table->string('down_payment');
            $table->string('monthly_payment');
            $table->integer('number_of_payments')->nullable();
            $table->string('broker_fee');
            $table->boolean('recommended');
            $table->date('effective_date');
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
        Schema::dropIfExists('selected_quote');
    }
};
