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
        Schema::table('cancellation_report', function (Blueprint $table) {
            $table->string('agent_remarks')->nullable()->change();
            $table->string('recovery_action')->nullable()->change();
            $table->date('reinstated_date')->nullable()->change();
            $table->date('reinstated_eligibility_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cancellation_report', function (Blueprint $table) {
            //
            $table->string('agent_remarks')->nullable(false)->change();
            $table->string('recovery_action')->nullable(false)->change();
            $table->date('reinstated_date')->nullable(false)->change();
            $table->date('reinstated_eligibility_date')->nullable(false)->change();
        });
    }
};