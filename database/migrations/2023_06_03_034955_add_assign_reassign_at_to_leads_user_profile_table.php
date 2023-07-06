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
        Schema::table('leads_user_profile', function (Blueprint $table) {

            $table->timestamp('assigned_at')->after('user_profile_id')->nullable();
            $table->timestamp('reassigned_at')->after('assigned_at')->nullable();
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leads_user_profile', function (Blueprint $table) {
            $table->dropColumn('assigned_at');
            $table->dropColumn('reassigned_at');
        });
    }
};
