<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repository\CartRepository;
use App\Repository\CategoryRepository;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index() {
        $categories = CategoryRepository::getAllCategory();
        // dd($categories);
        return view('frontend.pages.home', compact('categories'));
    }

    public function listProducts() {
        $categories = CategoryRepository::getAllCategory();
        return view('frontend.pages.products', compact('categories'));
    }

    public function listProductSlug($slug) {
        $slugCategory = CategoryRepository::findCategorySlug($slug);
        if(!$slugCategory) {
            return redirect(url('products'));
        }
        $categories = CategoryRepository::getAllCategory();

        return view('frontend.pages.products', compact('categories'));
    }

    public function listCarts() {
        $carts = CartRepository::listCarts();
        return view('frontend.pages.carts', compact('carts'));
    }
}
