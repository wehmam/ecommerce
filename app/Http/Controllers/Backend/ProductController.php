<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductPhoto;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with([
            'category' => fn($category) => $category->select('id', 'name')
        ])
            ->paginate(10);
        return view('backend.pages.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = CategoryRepository::getAllCategory();
        return view('backend.pages.products.form', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $response = ProductRepository::saveProduct($request->validated());
        alertNotify($response['status'], $response['message']);
        if(!$response['status']) {
            return redirect()->back()->withInput();
        }
        return redirect(url("/backend/product"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::with(['category', 'productPhotos'])->findOrFail($id);
        return view("backend.pages.products.detail", compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::with([])->get();
        $product  = Product::with(['productPhotos'])->findOrFail($id);
        return view("backend.pages.products.form", compact('category', 'product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $response = (new ProductRepository())->updateProduct($request->validated(), $id);
        alertNotify($response['status'], $response['message']);
        if(!$response['status']) {
            return redirect()->back()->withInput();
        }
        return redirect(url("/backend/product"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function deletePhotoById($id) {
        $productPhoto = ProductPhoto::findOrFail($id);
        if(Storage::exists($productPhoto["image"])) {
            Storage::delete($productPhoto["image"]);
        }

        $productPhoto->delete();
        return response()->json(responseCustom(
            "success delete photo",
            true
        ));
    }
}
