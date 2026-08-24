<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->string('highlights_heading')->nullable();
            $table->string('inclusions_heading')->nullable();
            $table->string('accommodations_heading')->nullable();
            $table->string('additional_infos_heading')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->dropColumn([
                'highlights_heading',
                'inclusions_heading',
                'accommodations_heading',
                'additional_infos_heading'
            ]);
        });
    }
};
