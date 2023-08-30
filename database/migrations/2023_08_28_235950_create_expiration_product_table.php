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
        Schema::create('expiration_product_table', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads');
            $table->integer('product');
            $table->timestamp('expiration_date');
            $table->string('prior_carrier');
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
        Schema::dropIfExists('expiration_product_table');
    }
};
