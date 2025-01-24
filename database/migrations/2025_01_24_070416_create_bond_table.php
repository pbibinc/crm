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
        Schema::create('bond', function (Blueprint $table) {
            $table->id();
            $table->foreignId('general_information_id')->constrained('general_information_table');
            $table->string('bond_state');
            $table->string('bond_type');
            $table->string('ssn');
            $table->date('date_of_birth');
            $table->string('marital_status');
            $table->string('contractor_license');
            $table->string('bond_obligee');
            $table->longText('obligee_address');
            $table->string('bond_amount');
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
        Schema::dropIfExists('bond');
    }
};