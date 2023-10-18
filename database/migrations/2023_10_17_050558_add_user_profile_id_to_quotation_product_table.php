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
        Schema::table('quotation_product_table', function (Blueprint $table) {
            //
        $table->foreignId('user_profile_id')->after('status')->nullable()->constrained('user_profiles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quotation_product_table', function (Blueprint $table) {
            //
            $table->dropForeign(['user_profile_id']);
            $table->dropColumn('user_profile_id');
        });
    }
};
