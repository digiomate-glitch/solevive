<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('home_hero_top_text')->nullable();
            $table->text('home_hero_headline')->nullable();
            $table->text('home_hero_subtitle')->nullable();
            $table->string('home_hero_btn1_text')->nullable();
            $table->string('home_hero_btn1_link')->nullable();
            $table->string('home_hero_btn2_text')->nullable();
            $table->string('home_hero_btn2_link')->nullable();
            $table->string('home_hero_stat1_title')->nullable();
            $table->string('home_hero_stat1_value')->nullable();
            $table->string('home_hero_stat2_title')->nullable();
            $table->string('home_hero_stat2_value')->nullable();
            $table->string('home_hero_stat3_title')->nullable();
            $table->string('home_hero_stat3_value')->nullable();
            $table->string('home_hero_image')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'home_hero_top_text', 'home_hero_headline', 'home_hero_subtitle',
                'home_hero_btn1_text', 'home_hero_btn1_link',
                'home_hero_btn2_text', 'home_hero_btn2_link',
                'home_hero_stat1_title', 'home_hero_stat1_value',
                'home_hero_stat2_title', 'home_hero_stat2_value',
                'home_hero_stat3_title', 'home_hero_stat3_value',
                'home_hero_image'
            ]);
        });
    }
};

