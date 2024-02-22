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
        Schema::table('policy_details_table', function (Blueprint $table) {
            $table->foreignId('media_id')->nullable()->after('expiration_date')->constrained('metadata');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('policy_details_table', function (Blueprint $table) {
           // Drop foreign key constraint
        $table->dropForeign(['media_id']);
        // Now drop the column
        $table->dropColumn('media_id');
        });
    }
};