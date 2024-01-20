@extends('frontend.layouts')
@section('title', 'Cart')
@section('content')
<div class="cart-table-area section-padding-100">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="cart-title mt-50">
                    <h2>Shopping Cart</h2>
                </div>

                <div class="cart-table clearfix">
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($carts as $item)
                                <tr>
                                    <td class="cart_product_img">
                                        <a href="#">
                                            <img src="{{ env("PRODUCTION_URL") . Storage::url($item->product->productPhotos[0]->image) }}" alt="">
                                        </a>
                                    </td>
                                    <td class="cart_product_desc">
                                        <h5>
                                            {{ $item->product->title }}
                                        </h5>
                                    </td>
                                    <td class="price">
                                        <span id="priceProduct">
                                            Rp .{{ number_format($item->product->price, 0) }}
                                        </span>
                                    </td>
                                    <td class="qty">
                                        <div class="qty-btn d-flex">
                                            <p>Qty</p>
                                            <div class="quantity">
                                                <p>{{ $item->quantity }}</p>
                                                {{-- <span class="qty-minus" onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty ) &amp;&amp; qty &gt; 1 ) effect.value--;return false;"><i class="fa fa-minus" aria-hidden="true"></i></span> --}}
                                                {{-- <input type="number" class="qty-text" id="qty" step="1" min="1" max="300" name="quantity" value="{{ $item->product->qty }}"> --}}
                                                {{-- <span class="qty-plus" onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty )) effect.value++;return false;"><i class="fa fa-plus" aria-hidden="true"></i></span> --}}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="cart_product_img"></td>
                                    <td class="cart_product_desc"></td>
                                    <td class="price">
                                        <h6>Empty Cart!</h6>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="cart-summary">
                    <h5>Cart Total</h5>
                    <ul class="summary-table">
                        <li><span>subtotal:</span> <span>Rp. {{ number_format($carts->sum('total_price'), 0) }}</span></li>
                        <li><span>delivery:</span> <span>Free</span></li>
                        <li><span>total:</span> <span>Rp. {{ number_format($carts->sum('total_price'), 0) }}</span></li>
                    </ul>
                    <div class="cart-btn mt-100">
                        <a href="{{ url('/checkout') }}" class="btn amado-btn w-100">Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
