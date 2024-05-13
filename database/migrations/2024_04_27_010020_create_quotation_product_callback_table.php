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
        Schema::create('quotation_product_callback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_product_id')->constrained('quotation_product_table');
            $table->dateTime('date_time');
            $table->string('remarks', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotation_product_callback');
    }
};