<?php

namespace App\Repository;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryRepository {

    public static function getAllCategory() {
        return Cache::remember('all-categories', 5,  function() {
            return Category::where('is_active', 1)
                ->get();
        });
    }

    public static function findCategorySlug($slug) {
        return Cache::remember('category-' . $slug, 5, function() use($slug) {
            return Category::where('slug', $slug)->where('is_active', 1)
                ->first();
        });
    }
}
