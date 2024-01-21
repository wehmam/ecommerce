<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddToCartRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Repository\CartRepository;
use App\Repository\CategoryRepository;
use App\Repository\CheckoutRepository;
use App\Repository\PaymentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index() {
        $categories = CategoryRepository::getAllCategory();
        return view('frontend.pages.home', compact('categories'));
    }

    public function listProducts(Request $request) {
        $categories    = CategoryRepository::getAllCategory();
        $products      = Product::with(["category"])->where('is_active', 1);
        $filters       = $request->only("keyword");

        if(isset($filters['keyword'])) {
            $products->where("title", "LIKE", "%". $filters['keyword'] ."%");
        }
        $products = $products->paginate(6);

        return view('frontend.pages.products', compact('categories', 'products'));
    }

    public function listProductSlug($slug) {
        $slugCategory = CategoryRepository::findCategorySlug($slug);
        if(!$slugCategory) {
            return redirect(url('products'));
        }
        $categories = CategoryRepository::getAllCategory();
        $products      = Product::with(['productPhotos'])
            ->where('category_id', $slugCategory->id)
            ->where('is_active', 1)
            ->paginate(6);

        return view('frontend.pages.products', compact('products', 'categories'));
    }

    public function detailProduct($id) {
        $product      = Product::with(['productPhotos', 'category'])
            ->find($id);

        return view("frontend.pages.detail", compact("product"));
    }

    public function listCarts() {
        $carts = CartRepository::listCarts();
        return view('frontend.pages.carts', compact('carts'));
    }

    public function addToCarts(AddToCartRequest $request) {
        $response = CartRepository::addToCarts($request->validated());
        alertNotify($response['status'], $response['message']);
        if(!$response['status']) {
            return redirect()
                ->back()
                ->withInput();
        }

        return redirect(url("/products"));
    }

    public function checkout() {
        $provinces = listProvinces();
        $carts = Cart::with(['user', 'product', 'product.productPhotos'])
            ->where("user_id", Auth::user()->id)
            ->get();

        return view("frontend.pages.checkout", compact('provinces', 'carts'));
    }

    public function checkoutPost(Request $request) {
        $response = CheckoutRepository::checkout($request);
        alertNotify($response['status'], $response['message']);
        if(!$response['status']) {
            return redirect()
                ->back()
                ->withInput();
        }

        return redirect(url("payment/" . $response['data']['invoice_no']));
    }

    public function listInvoice() {
        $orders = Order::get();
        return view("frontend.pages.invoices", compact('orders'));
    }

    public function payment($invoice) {
        $order = Order::with(["orderDetails", "orderDetails.product"])
        ->where([
            ["invoice_no", $invoice],
            ["user_id", Auth::user()->id]
        ])->first();

        if(!$order) {
            alertNotify(false, "Invoice not exist!");
            return redirect(url('products'));
        }

        return view("frontend.pages.payment", compact('order'));
    }

    public function doToken(Request $request) {
        $requestToken = PaymentRepository::requestSnapToken($request->all());

        if(!$requestToken["status"]) {
            return response()->json([
                "status"    => false,
                "data"      => $requestToken["message"]
            ]);
        }

        return response()->json([
            "status"    => true,
            "data"      => $requestToken["data"]["access_token"]
        ]);
    }
}
