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
        Schema::create('classcode_percentage_table', function (Blueprint $table) {
            $table->id();
            $table->foreignId('general_liabilities_id')->constrained('general_liabilities_table')->onDelete('cascade');
            $table->foreignId('classcode_id')->constrained('class_code_leads_table')->onDelete('cascade');
            $table->bigInteger('percentage');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classcode_percentage_table');
    }
};