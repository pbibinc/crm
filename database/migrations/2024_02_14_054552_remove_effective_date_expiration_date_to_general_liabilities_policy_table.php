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
        Schema::table('general_liabilities_policy_details', function (Blueprint $table) {
            //
            $table->dropColumn('effective_date');
            $table->dropColumn('expiry_date');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('general_liabilities_policy_details', function (Blueprint $table) {
            //
            $table->date('effective_date')->default(Carbon::now())->after('product_comp');
            $table->date('expiry_date')->default(Carbon::now())->after('effective_date');
        });
    }
};
