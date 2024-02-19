<?php

use Carbon\Carbon;
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
            //
            $table->date('effective_date')->default(Carbon::now())->after('payment_mode');
            $table->date('expiration_date')->default(Carbon::now())->after('effective_date');
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
            $table->dropColumn('effective_date');
            $table->dropColumn('expiration_date');
        });
    }
};