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
            // Drop the foreign key constraint (make sure the key name matches your DB definition)
            $table->dropForeign(['policy_details_id']);

            // Drop the policy_details_id column
            $table->dropColumn('policy_details_id');

            // Add the new foreign key column lead_id after the id column
            $table->foreignId('lead_id')->after('id')->constrained('leads');
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
            // Drop the new foreign key constraint for lead_id
            $table->dropForeign(['lead_id']);

            // Drop the lead_id column
            $table->dropColumn('lead_id');

            // Re-add the policy_details_id column with the foreign key constraint
            $table->foreignId('policy_details_id')->after('id')->constrained('policy_details_table');
        });
    }
};