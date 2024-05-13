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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_product_id')->constrained('quotation_product_table');
            $table->string('receiver_email');
            $table->string('name');
            $table->string('type');
            $table->timestamp('sending_date');
            $table->foreignId('template_id')->constrained('templates');
            $table->foreignId('sender_id')->constrained('user_profiles');
            $table->string('status');
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
        Schema::dropIfExists('messages');
    }
};