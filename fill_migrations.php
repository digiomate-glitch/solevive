<?php
$dir = __DIR__ . '/database/migrations/';

function updateMigration($dir, $pattern, $upContent) {
    $files = glob($dir . '*' . $pattern . '.php');
    if (empty($files)) return;
    $file = $files[0];
    
    $content = file_get_contents($file);
    
    // Replace everything between Schema::create(..., function(Blueprint $table) { ... });
    $replacement = "Schema::create('{$pattern}', function (Blueprint \$table) {\n" . $upContent . "\n        });";
    
    $content = preg_replace("/Schema::create\('{$pattern}', function \(Blueprint \\\$table\) \{.*?\}\);/s", $replacement, $content);
    
    file_put_contents($file, $content);
}

// 1. Categories
updateMigration($dir, 'categories', "
            \$table->id();
            \$table->string('name');
            \$table->string('slug')->unique();
            \$table->text('description')->nullable();
            \$table->integer('sort_order')->default(0);
            \$table->timestamps();
");

// 2. Tours
updateMigration($dir, 'tours', "
            \$table->id();
            \$table->string('title');
            \$table->string('slug')->unique();
            \$table->string('hero_image')->nullable();
            \$table->string('overview_image')->nullable();
            \$table->string('price')->nullable();
            \$table->integer('duration_days')->nullable();
            \$table->integer('destinations_count')->nullable();
            \$table->string('max_guests')->nullable();
            \$table->string('countries')->nullable();
            \$table->text('hero_text')->nullable();
            \$table->string('overview_heading')->nullable();
            \$table->text('overview_desc')->nullable();
            \$table->boolean('is_published')->default(true);
            \$table->integer('sort_order')->default(0);
            \$table->string('seo_title')->nullable();
            \$table->text('seo_desc')->nullable();
            \$table->timestamps();
");

// 3. Category_Tour
updateMigration($dir, 'category_tour', "
            \$table->id();
            \$table->foreignId('category_id')->constrained()->cascadeOnDelete();
            \$table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            \$table->timestamps();
");

// 4. Tour Highlights
updateMigration($dir, 'tour_highlights', "
            \$table->id();
            \$table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            \$table->text('content');
            \$table->integer('sort_order')->default(0);
            \$table->timestamps();
");

// 5. Tour Inclusions
updateMigration($dir, 'tour_inclusions', "
            \$table->id();
            \$table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            \$table->text('content');
            \$table->integer('sort_order')->default(0);
            \$table->timestamps();
");

// 6. Tour Accommodations
updateMigration($dir, 'tour_accommodations', "
            \$table->id();
            \$table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            \$table->string('hotel_name')->nullable();
            \$table->text('description')->nullable();
            \$table->string('image')->nullable();
            \$table->integer('sort_order')->default(0);
            \$table->timestamps();
");

// 7. Tour Additional Infos
updateMigration($dir, 'tour_additional_infos', "
            \$table->id();
            \$table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            \$table->text('content');
            \$table->integer('sort_order')->default(0);
            \$table->timestamps();
");

echo "Migrations updated successfully.\n";
