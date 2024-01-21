<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $categoryTotal = Category::count();
        $productsTotal = Product::count();
        $totalOrders = Order::count();
        $incomeTotal = Order::whereNotNull("paid_at")->sum("total_amount");
        
        return view('backend.pages.dashboard', compact("categoryTotal", "productsTotal", "totalOrders", "incomeTotal"));
    }
}
