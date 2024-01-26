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
        Schema::create('bound_information_table', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quoatation_product_id')->constrained('quotation_product_table');
            $table->foreignId('user_profile_id')->constrained('user_profiles');
            $table->date('bound_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bound_information_table');
    }
};