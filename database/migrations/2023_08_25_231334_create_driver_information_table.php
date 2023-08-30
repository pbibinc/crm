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
        Schema::create('driver_information_table', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commercial_auto_id')->constrained('commercial_auto_table');
            $table->string('fullname');
            $table->timestamp('date_of_birth');
            $table->string('driver_license_number');
            $table->string('marital_status');
            $table->integer('years_of_experience');
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
        Schema::dropIfExists('driver_information_table');
    }
};
