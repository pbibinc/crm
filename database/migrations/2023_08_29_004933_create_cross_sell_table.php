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
        Schema::create('cross_sell_table', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads');
            $table->integer('product');
            $table->string('cross_sell');
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
        Schema::dropIfExists('cross_sell_table');
    }
};
