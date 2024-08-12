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
        Schema::create('cancellation_endorsement_report', function (Blueprint $table) {
            $table->id();
            $table->foreignId('policy_details_id')->constrained('policy_details_table');
            $table->string('type_of_cancellation');
            $table->foreignId('media_id')->constrained('metadata');
            $table->foreignId('cancelled_by_id')->constrained('user_profiles');
            $table->string('agent_remarks');
            $table->date('cancellation_date');
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
        Schema::dropIfExists('cancellation_endorsement_report');
    }
};