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
        Schema::table('cancelled_policy_for_recall', function (Blueprint $table) {
            $table->foreignId('last_touch_user_profile_id')
            ->nullable()
            ->after('date_to_call')
            ->constrained('user_profiles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cancelled_policy_for_recall', function (Blueprint $table) {
            //
            $table->dropForeign(['last_touch_user_profile_id']);
            $table->dropColumn('last_touch_user_profile_id');
        });
    }
};
