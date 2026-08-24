<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Tour;
use DOMDocument;
use DOMXPath;
use Illuminate\Support\Str;

class ImportStaticDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Categories
        $smallGroup = Category::create([
            'name' => 'Small Group Tours',
            'slug' => 'small-group-tours',
            'sort_order' => 1
        ]);
        
        $privateTours = Category::create([
            'name' => 'Private Tours',
            'slug' => 'private-tours',
            'sort_order' => 2
        ]);

        $backupDir = base_path('static_backup');
        
        // Define tours to import and their categories
        $tours = [
            'angkor-wat-and-icons-of-southeast-asia' => $smallGroup->id,
            'cruising-the-mekong-and-angkor-wat' => $smallGroup->id,
            'epic-voyage-around-southeast-asia' => $smallGroup->id,
            'icons-of-southeast-asia-private' => $privateTours->id,
            'thailand-family-adventure' => $privateTours->id,
            'ultimate-thailand-adventure' => $privateTours->id,
            'luxury-tented-camps-of-southeast-asia' => $privateTours->id,
        ];

        $sort = 1;

        foreach ($tours as $slug => $categoryId) {
            $file = $backupDir . '/' . $slug . '.html';
            if (!file_exists($file)) continue;

            $html = file_get_contents($file);
            
            // Silence HTML5 parsing warnings
            libxml_use_internal_errors(true);
            $doc = new DOMDocument();
            $doc->loadHTML($html);
            libxml_clear_errors();
            $xpath = new DOMXPath($doc);

            // Extract Data using XPath
            
            // SEO
            $seoTitle = $this->getNodeContent($xpath, '//title');
            $seoDesc = $this->getNodeAttribute($xpath, '//meta[@name="description"]', 'content');
            
            // Hero
            $title = $this->getNodeContent($xpath, '//section[contains(@class, "detail-hero")]//h1');
            $heroText = $this->getNodeContent($xpath, '//section[contains(@class, "detail-hero")]//p[contains(@class, "lede")]');
            $heroImageStyle = $this->getNodeAttribute($xpath, '//section[contains(@class, "detail-hero")]', 'style');
            $heroImage = '';
            if (preg_match('/url\([\'"]?(.*?)[\'"]?\)/', $heroImageStyle, $matches)) {
                $heroImage = $matches[1];
            }

            // Facts
            $durationDays = (int) $this->getNodeContent($xpath, '//div[contains(@class, "detail-facts")]/div[1]/strong');
            $destinationsCount = (int) $this->getNodeContent($xpath, '//div[contains(@class, "detail-facts")]/div[2]/strong');
            $maxGuests = $this->getNodeContent($xpath, '//div[contains(@class, "detail-facts")]/div[3]/strong');
            $price = $this->getNodeContent($xpath, '//div[contains(@class, "detail-facts")]/div[4]/strong');
            
            // Overview
            $overviewImage = $this->getNodeAttribute($xpath, '//div[contains(@class, "tour-body")]/div[1]/img[1]', 'src');
            $overviewHeading = $this->getNodeContent($xpath, '//div[contains(@class, "tour-body")]/div[1]/div[1]/h2');
            $overviewDesc = $this->getNodeContent($xpath, '//div[contains(@class, "tour-body")]/div[1]/div[1]/p[contains(@class, "lede")]');

            // Create Tour
            $tour = Tour::create([
                'title' => $title,
                'slug' => $slug,
                'hero_image' => $heroImage,
                'overview_image' => $overviewImage,
                'price' => $price,
                'duration_days' => $durationDays,
                'destinations_count' => $destinationsCount,
                'max_guests' => $maxGuests,
                'hero_text' => $heroText,
                'overview_heading' => $overviewHeading,
                'overview_desc' => $overviewDesc,
                'seo_title' => $seoTitle,
                'seo_desc' => $seoDesc,
                'sort_order' => $sort++,
            ]);

            // Assign Category
            $tour->categories()->attach($categoryId);

            // Highlights
            $highlights = $xpath->query('//div[contains(@class, "tour-body")]/div[1]/div[2]//ul/li');
            foreach ($highlights as $i => $node) {
                $tour->highlights()->create(['content' => trim($node->textContent), 'sort_order' => $i]);
            }

            // Inclusions
            $inclusions = $xpath->query('//div[contains(@class, "tour-body")]/div[1]/div[4]//ul/li');
            foreach ($inclusions as $i => $node) {
                $tour->inclusions()->create(['content' => trim($node->textContent), 'sort_order' => $i]);
            }

            // Accommodations
            $accommodations = $xpath->query('//div[contains(@class, "tour-body")]/div[1]/div[5]//div[contains(@class, "stay-card")]');
            foreach ($accommodations as $i => $node) {
                $img = $xpath->query('.//img', $node)->item(0);
                $h4 = $xpath->query('.//h4', $node)->item(0);
                $p = $xpath->query('.//p', $node)->item(0);
                
                $tour->accommodations()->create([
                    'hotel_name' => $h4 ? trim($h4->textContent) : '',
                    'description' => $p ? trim($p->textContent) : '',
                    'image' => $img ? $img->getAttribute('src') : '',
                    'sort_order' => $i
                ]);
            }

            // Additional Info
            $addInfo = $xpath->query('//div[contains(@class, "tour-body")]/div[1]/div[6]//ul/li');
            foreach ($addInfo as $i => $node) {
                $tour->additionalInfos()->create(['content' => trim($node->textContent), 'sort_order' => $i]);
            }
        }
    }

    private function getNodeContent($xpath, $query) {
        $nodes = $xpath->query($query);
        return $nodes->length > 0 ? trim($nodes->item(0)->textContent) : null;
    }

    private function getNodeAttribute($xpath, $query, $attr) {
        $nodes = $xpath->query($query);
        return $nodes->length > 0 ? trim($nodes->item(0)->getAttribute($attr)) : null;
    }
}
