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
        Schema::create('quote_comparison_table', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_product_id')->constrained('quotation_product_table');
            $table->foreignId('quotation_market_id')->constrained('quotation_market_table');
            $table->string('full_payment');
            $table->string('down_payment');
            $table->string('monthly_payment');
            $table->string('broker_fee');
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
        Schema::dropIfExists('quote_comparison_table');
    }
};
