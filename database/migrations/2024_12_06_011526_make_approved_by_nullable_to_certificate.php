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
        Schema::table('certificate', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['approved_by']);

            // Modify the 'approved_by' column to make it nullable
            $table->unsignedBigInteger('approved_by')->nullable()->change();

            // Re-add the foreign key constraint
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('certificate', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['approved_by']);

            // Revert the 'approved_by' column to be non-nullable
            $table->unsignedBigInteger('approved_by')->nullable(false)->change();

            // Re-add the foreign key constraint
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('cascade');
        });
    }
};