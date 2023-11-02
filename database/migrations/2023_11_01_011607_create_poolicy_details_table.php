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
        Schema::create('policy_details_table', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_product_id')->constrained('quotation_product_table');
            $table->string('policy_number');
            $table->string('carrier');
            $table->string('insurer');
            $table->string('payment_mode');
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
        Schema::dropIfExists('policy_details_table');
    }
};