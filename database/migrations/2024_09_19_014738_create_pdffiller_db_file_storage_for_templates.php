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
        Schema::create('pdffiller_templates_files_table', function (Blueprint $table) {
            $table->id();
            $table->string('template_name');
            $table->foreignId('media_id')->constrained('metadata');
            $table->foreignId('uploaded_by')->constrained('user_profiles');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pdffiller_templates_files_table');
    }
};
