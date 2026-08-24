<?php

namespace App\Traits;

trait CleansCkeditorContent
{
    /**
     * Boot the trait to hook into the saving event.
     */
    public static function bootCleansCkeditorContent()
    {
        static::saving(function ($model) {
            $fields = $model->getCkeditorFields();
            foreach ($fields as $field) {
                if (!empty($model->{$field})) {
                    $model->{$field} = self::cleanCkeditorLists($model->{$field});
                }
            }
        });
    }

    /**
     * Get the fields that contain CKEditor content.
     * By default, returns ['content']. Models can override this if needed.
     */
    public function getCkeditorFields(): array
    {
        return ['content'];
    }

    /**
     * Clean CKEditor generated lists by removing unnecessary <p> tags from within <li> tags.
     */
    public static function cleanCkeditorLists(?string $html): ?string
    {
        if (empty($html) || !str_contains($html, '<li>')) {
            return $html;
        }

        $dom = new \DOMDocument();
        // Suppress warnings for malformed HTML
        @$dom->loadHTML('<?xml encoding="utf-8" ?>' . $html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        
        $lis = $dom->getElementsByTagName('li');
        $liNodes = [];
        foreach ($lis as $li) {
            $liNodes[] = $li;
        }

        foreach ($liNodes as $li) {
            $children = [];
            foreach ($li->childNodes as $node) {
                if ($node->nodeType === XML_ELEMENT_NODE) {
                    $children[] = $node;
                }
            }
            // If the li contains exactly one block element and it is a <p> tag
            if (count($children) === 1 && $children[0]->nodeName === 'p') {
                $p = $children[0];
                // Move all children of p to li
                while ($p->childNodes->length > 0) {
                    $li->insertBefore($p->childNodes->item(0), $p);
                }
                $li->removeChild($p);
            }
        }
        
        $output = $dom->saveHTML();
        $output = str_replace(['<?xml encoding="utf-8" ?>', '<?xml encoding="utf-8"?>'], '', $output);
        return trim($output);
    }
}
