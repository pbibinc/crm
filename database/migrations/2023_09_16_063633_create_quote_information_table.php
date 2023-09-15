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
        Schema::create('quote_information_table', function (Blueprint $table) {
            $table->id();
            $table->foreignId('telemarket_id')->constrained('user_profiles');
            $table->foreignId('quoting_agent_id')->constrained('quote_lead_table');
            $table->integer('status');
            $table->timestamp('sent_out_date');
            $table->string('remarks');
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
        Schema::dropIfExists('quote_information_table');
    }
};
