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
            $table->foreignId('product_appointer_id')->default(1)->after('user_profile_id')->constrained('user_profiles');
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
            // Drop the foreign key constraint first
        $table->dropForeign(['product_appointer_id']);

        // Then drop the column
        $table->dropColumn('product_appointer_id');
        });
    }
};
