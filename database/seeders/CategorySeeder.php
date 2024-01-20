<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ["Iphone", "Ipad", "Macbook", "Watch", "Airpods", "Accessories"];
        $bodyParams = collect([]);
        foreach($categories as $cat) {
            $bodyParams->push([
                'slug' => Str::slug($cat),
                'name' => $cat,
                'main_image' => asset("assets/img/category-img/" .$cat. ".jpeg"),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        Category::insert($bodyParams->toArray());
    }
}
