@extends('frontend.layouts')
@section('title', 'Product Detail')
@section('content')
     <!-- Product Details Area Start -->
     <div class="single-product-area section-padding-100 clearfix">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mt-50">
                            <li class="breadcrumb-item"><a href="{{ url("/") }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ url("/products/" . $product->category->slug) }}">{{ $product->category->slug }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $product->title }}</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-7">
                    <div class="single_product_thumb">
                        <div id="product_details_slider" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                    @php
                                        $activeCar = true;
                                    @endphp
                                @foreach ($product->productPhotos as $key => $photo)
                                    <li class="{{ $activeCar == true ? "active" : "" }}" data-target="#product_details_slider" data-slide-to="{{ $key }}" style="background-image: url({{ env("PRODUCTION_URL") . Storage::url($photo->image) }});"></li>
                                    @php
                                        $activeCar = false;
                                    @endphp
                                @endforeach
                            </ol>
                            <div class="carousel-inner">
                                    @php
                                        $activeCar = true;
                                    @endphp
                                @foreach ($product->productPhotos as $key => $photo)
                                    <div class="carousel-item {{ $activeCar == true ? "active" : "" }}">
                                        <a class="gallery_img" href="{{ env("PRODUCTION_URL") . Storage::url($photo->image) }}">
                                            <img class="d-block w-100" src="{{ env("PRODUCTION_URL") . Storage::url($photo->image) }}" alt="First slide">
                                        </a>
                                    </div>
                                    @php
                                        $activeCar = false;
                                    @endphp
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-5">
                    <div class="single_product_desc">
                        <!-- Product Meta Data -->
                        <div class="product-meta-data">
                            <div class="line"></div>
                            <p class="product-price">Rp. {{ number_format($product->price, 0) }}</p>
                            <a href="product-details.html">
                                <h6>{{ $product->title }}</h6>
                            </a>
                            <!-- Ratings & Review -->
                            <div class="ratings-review mb-15 d-flex align-items-center justify-content-between">
                                <div class="ratings">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                </div>
                            </div>
                            <!-- Avaiable -->
                            <p class="{{ $product->is_active ? "avaibility" : "" }}"><i class="fa fa-circle"></i> {{ $product->is_active ? "In Stock" : "Out Stock" }}</p>
                        </div>

                        <div class="short_overview my-5">
                            {{ $product->description }}
                        </div>

                        <!-- Add to Cart Form -->
                        <form action="{{ url("cart/order") }}" class="cart clearfix" method="post">
                            @csrf
                            <input type="hidden" value="{{ $product->id }}" name="productId">
                            <div class="cart-btn d-flex mb-50">
                                <p>Qty</p>
                                <div class="quantity">
                                    <span class="qty-minus" onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty ) &amp;&amp; qty &gt; 1 ) effect.value--;return false;"><i class="fa fa-caret-down" aria-hidden="true"></i></span>
                                        <input type="number" class="qty-text" id="qty" step="1" min="1" max="300" name="quantity" value="1">
                                    <span class="qty-plus" onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty )) effect.value++;return false;"><i class="fa fa-caret-up" aria-hidden="true"></i></span>
                                </div>
                            </div>
                            <button type="submit" class="btn amado-btn">Add to cart</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Product Details Area End -->
@endsection
