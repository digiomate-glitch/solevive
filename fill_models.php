<?php
$dir = __DIR__ . '/app/Models/';

function updateModel($dir, $model, $content) {
    $file = $dir . $model . '.php';
    if (!file_exists($file)) return;
    $fileContent = file_get_contents($file);
    
    // Replace the inside of the class
    $replacement = "class {$model} extends Model\n{\n    use HasFactory;\n    protected \$guarded = [];\n\n" . $content . "\n}";
    
    $fileContent = preg_replace("/class {$model} extends Model\s*\{.*?\}/s", $replacement, $fileContent);
    file_put_contents($file, $fileContent);
}

// 1. Category
updateModel($dir, 'Category', "
    public function tours() {
        return \$this->belongsToMany(Tour::class)->orderBy('sort_order');
    }
");

// 2. Tour
updateModel($dir, 'Tour', "
    public function categories() {
        return \$this->belongsToMany(Category::class);
    }
    public function highlights() {
        return \$this->hasMany(TourHighlight::class)->orderBy('sort_order');
    }
    public function inclusions() {
        return \$this->hasMany(TourInclusion::class)->orderBy('sort_order');
    }
    public function accommodations() {
        return \$this->hasMany(TourAccommodation::class)->orderBy('sort_order');
    }
    public function additionalInfos() {
        return \$this->hasMany(TourAdditionalInfo::class)->orderBy('sort_order');
    }
");

// 3. Dependent Models
foreach (['TourHighlight', 'TourInclusion', 'TourAccommodation', 'TourAdditionalInfo'] as $model) {
    updateModel($dir, $model, "
    public function tour() {
        return \$this->belongsTo(Tour::class);
    }
");
}

echo "Models updated successfully.\n";
