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
        Schema::create('audit_information_table', function (Blueprint $table) {
            $table->id();
            $table->foreignId('policy_details_id')->constrained('policy_details_table');
            $table->foreignId('audit_letter_id')->constrained('metadata');
            $table->foreignId('processed_by')->constrained('user_profiles');
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
        Schema::dropIfExists('audit_information_table');
    }
};