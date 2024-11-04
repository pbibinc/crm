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
        Schema::table('payment_information_table', function (Blueprint $table) {
            $table->foreignId('requested_by')
                  ->nullable()
                  ->constrained('user_profiles')
                  ->after('note')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_information_table', function (Blueprint $table) {
            $table->dropForeign(['requested_by']);
            $table->dropColumn('requested_by');
        });
    }
};