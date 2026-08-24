<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('hero_image')->nullable();
            $table->string('overview_image')->nullable();
            $table->string('price')->nullable();
            $table->integer('duration_days')->nullable();
            $table->integer('destinations_count')->nullable();
            $table->string('max_guests')->nullable();
            $table->string('countries')->nullable();
            $table->text('hero_text')->nullable();
            $table->string('overview_heading')->nullable();
            $table->text('overview_desc')->nullable();
            $table->boolean('is_published')->default(true);
            $table->integer('sort_order')->default(0);
            $table->string('seo_title')->nullable();
            $table->text('seo_desc')->nullable();
            $table->timestamps();
        });

        Schema::create('category_tour', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('tour_highlights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            $table->text('content');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('tour_inclusions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            $table->text('content');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('tour_accommodations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            $table->string('hotel_name')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('tour_additional_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            $table->text('content');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_additional_infos');
        Schema::dropIfExists('tour_accommodations');
        Schema::dropIfExists('tour_inclusions');
        Schema::dropIfExists('tour_highlights');
        Schema::dropIfExists('category_tour');
        Schema::dropIfExists('tours');
        Schema::dropIfExists('categories');
    }
};
