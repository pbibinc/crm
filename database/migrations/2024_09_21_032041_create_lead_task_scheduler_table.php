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
        Schema::create('lead_task_scheduler_table', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assigned_by')->constrained('user_profiles');
            $table->foreignId('assigned_to')->constrained('user_profiles');
            $table->foreignId('leads_id')->constrained('leads');
            $table->string('description');
            $table->dateTime('date_schedule');
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
        Schema::dropIfExists('lead_task_scheduler_table');
    }
};