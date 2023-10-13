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
        Schema::table('quote_lead_table', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['user_profiles_id']);

            // Change column to nullable
            $table->unsignedBigInteger('user_profiles_id')->nullable()->change();

            // Re-add foreign key constraint
            $table->foreign('user_profiles_id')->references('id')->on('user_profiles')->onDelete('set null');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quote_lead_table', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['user_profiles_id']);

            // Change the column back to NOT nullable
            $table->unsignedBigInteger('user_profiles_id')->nullable()->change();

            // Re-add the foreign key constraint without the "set null" on delete
            $table->foreign('user_profiles_id')->references('id')->on('user_profiles');
        });
    }

};
