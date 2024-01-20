@extends('frontend.layouts')
@section('title', 'Checkout')
@section('content')
<div class="cart-table-area section-padding-100">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="checkout_details_area mt-50 clearfix">

                    <div class="cart-title">
                        <h2>Checkout</h2>
                    </div>

                    <form id="checkoutSubmit" action="{{ url("/checkout") }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-12 mb-3">
                                <select class="w-100" name="province" id="province">
                                    <option value="" disabled selected>-- Choose Province --</option>
                                    @forelse ($provinces as $province)
                                        <option value="{{ strtoupper($province['provinsi_nama']) }}">{{ strtoupper($province['provinsi_nama']) }}</option>
                                    @empty
                                        <option value="NULL">-- no province data loaded --</option>
                                    @endforelse
                                    <option value="indonesia">Indonesia</option>
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <input type="text" class="form-control" name="city" id="city" placeholder="City" value="{{ old('city') }}">
                            </div>
                            <div class="col-6 mb-3">
                                <input type="text" class="form-control" name="district" id="district" placeholder="District" value="{{ old("district") }}">
                            </div>
                            <div class="col-12 mb-3">
                                {{-- <input type="text" class="form-control mb-3" name="address" id="street_address" placeholder="Address" value="{{ old("address") }}"> --}}
                                <textarea name="address" class="form-control w-100" id="address" cols="30" rows="10" placeholder="Address">{{ old("address") }}</textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="number" class="form-control" id="post_code" name="post_code" placeholder="Post Code" value="{{ old("post_code") }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="number" class="form-control" id="phone_number" name="phone" min="0" placeholder="Phone No" value="{{ old("phone") }}">
                            </div>
                            {{-- <div class="col-12 mb-3">
                                <textarea name="comment" class="form-control w-100" id="comment" cols="30" rows="10" placeholder="Leave a comment about your order"></textarea>
                            </div> --}}
                        </div>
                    </form>
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

                    <div class="payment-method">
                        <div class="custom-control custom-checkbox mr-sm-2">
                            <input type="checkbox" class="custom-control-input" id="cod" checked>
                            <label class="custom-control-label" for="cod">Cash on Delivery</label>
                        </div>
                    </div>

                    <div class="cart-btn mt-100">
                        <a onclick="submitBtn()" class="btn amado-btn w-100">Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('javascript')
    <script>
        function submitBtn() {
            document.getElementById("checkoutSubmit").submit()
        }
    </script>
@endsection
