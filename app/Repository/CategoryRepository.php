<?php

namespace App\Repository;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryRepository {

    public static function getAllCategory() {
        return Cache::remember('all-categories', 5,  function() {
            return Category::where('is_active', 1)
                ->get();
        });
    }

    public static function findCategory($id) {
        return Category::find($id);
    }

    public static function getPaginateCategory() {
        return Category::with([])
            ->paginate(10);
    }

    public static function findCategorySlug($slug) {
        return Cache::remember('category-' . $slug, 5, function() use($slug) {
            return Category::where('slug', $slug)->where('is_active', 1)
                ->first();
        });
    }

    public static function saveCategory($request) {
        try {
            $validator = \Validator::make($request->all() ,[
                "name"      => "required|unique:categories",
                "is_active" => "required",
                "main_image"     => "required|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
            ]);

            if($validator->fails()) {
                return responseCustom(implode(" - ", $validator->messages()->all()));
            }

            $pathFile = "public/images";
            if($request->hasFile("main_image")) {
                $image      = $request->file("main_image");
                $fileName   = time() . "-" . $image->getClientOriginalExtension();
                $pathFile   = Storage::putFile('public/images', $image);
            }

            $category               = new Category();
            $category->name         = $request->get('name');
            $category->slug         = Str::slug($request->get('name'));
            $category->is_active    = $request->get("is_active");
            $category->main_image   = env("APP_URL") . Storage::url($pathFile);
            $category->save();

            return responseCustom("Success to save category!", status: true, code: 200);
        } catch (\Exception $e) {
            return responseCustom("Err CR-SC : " . $e->getMessage());
        }
    }

    public static function updateCategory($request, $id) {
        try {
            $category = self::findCategory($id);
            if(!$category) {
                return responseCustom("Category Not Found!", code: 404);
            }

            $validator = \Validator::make($request->all() ,[
                "name"      => "required|unique:categories,id," .$id,
                "is_active" => "required",
            ]);

            if($validator->fails()) {
                return responseCustom(implode(" - ", $validator->messages()->all()));
            }

            if($request->hasFile("main_image")) {
                $validator = \Validator::make($request->all(), [
                    "main_image"     => "required|image|mimes:jpeg,png,jpg,gif,svg|max:2048"
                ]);

                if($validator->fails()) {
                    return responseCustom(implode(" - ", $validator->messages()->all()));
                }
                if(Storage::exists($category->main_image)) {
                    Storage::delete($category->main_image);
                }

                $pathFile = "public/images";
                if($request->hasFile("main_image")) {
                    $image      = $request->file("main_image");
                    $pathFile   = Storage::putFile('public/images/category', $image);
                }
                $category->main_image   = env("APP_URL") . Storage::url($pathFile);
            }

            $category->name         = $request->get('name');
            $category->slug         = Str::slug($request->get('name'));
            $category->is_active    = $request->get("is_active");
            $category->save();

            return responseCustom("Success to save category!", status: true, code: 200);
        } catch (\Exception $e) {
            return responseCustom($e->getMessage());
        }
    }

    public static function destroyData($id) {
        try {
            $category =self::findCategory($id);
            if(!$category) {
                return responseCustom("Category not found!", code: 404);
            }
            
            $category->forceDelete();

            return responseCustom("Success To delete category!", status: true, code: 200);
        } catch (\Exception $e) {
            return responseCustom($e->getMessage());
        }
    }
}
