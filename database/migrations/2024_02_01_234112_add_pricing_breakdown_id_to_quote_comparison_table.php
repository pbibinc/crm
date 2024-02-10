<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        Schema::table('quote_comparison_table', function (Blueprint $table) {
            //

            try{
                DB::beginTransaction();
                $table->foreignId('pricing_breakdown_id')->nullable()->after('quotation_market_id')->constrained('pricing_breakdown_table');
                DB::commit();
            }catch(\Exception $e){
                DB::rollback();
                Log::error($e->getMessage());
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quote_comparison_table', function (Blueprint $table) {
            try{
                DB::beginTransaction();
                $table->dropForeign('quote_comparison_table_pricing_breakdown_id_foreign');
                $table->dropColumn('pricing_breakdown_id');
                DB::commit();
            }catch(\Exception $e){
                DB::rollback();
                Log::error($e->getMessage());
            }
        });
    }
};
