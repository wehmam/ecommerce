@extends('frontend.layouts')
@section('title', 'Payments')
@section('content')
<div class="cart-table-area section-padding-100">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="cart-title mt-50">
                    <h2>Invoice {{ $order->invoice_no }}</h2>
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
                            @forelse ($order->orderDetails as $item)
                                <tr>
                                    <td class="cart_product_img">
                                        <a href="#">
                                            <img src="{{ Storage::url($item->product->productPhotos[0]->image) }}" alt="">
                                        </a>
                                    </td>
                                    <td class="cart_product_desc">
                                        <h5>
                                            {{ $item->product->title ?? "-" }}
                                        </h5>
                                    </td>
                                    <td class="price">
                                        <span id="priceProduct">
                                            Rp .{{ nominalFormat($item->product->price) }}
                                        </span>
                                    </td>
                                    <td class="qty">
                                        <div class="qty-btn d-flex">
                                            <p>Qty</p>
                                            <div class="quantity">
                                                <p>{{ $item->qty }}</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="cart_product_img"></td>
                                    <td class="cart_product_desc"></td>
                                    <td class="price">
                                        <h6>Empty Invoice!</h6>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="cart-summary">
                    <h5>Detail Order</h5>
                    <ul class="summary-table">
                        <li><span>subtotal:</span> <span>Rp. {{ nominalFormat($order->orderDetails->sum('total_price')) }}</span></li>
                        <li><span>delivery:</span> <span>Free</span></li>
                        <li><span>total:</span> <span>Rp. {{ nominalFormat($order->orderDetails->sum('total_price')) }}</span></li>
                        <li><span>Status Invoices</span>{{ $order->paid_at ? "PAID" : "NOT PAID" }}</li>

                        @if (!is_null($order->dump_payment) && is_null($order->paid_at))
                            @php
                                $dump = generateArrMidtrans($order->dump_payment);
                            @endphp
                            <hr />

                            <li><span>Bank :</span> <span>{{ strtoupper($dump["flag"]) }}</span></li>
                            @if (isset($dump['kode_perusahaan']) && $dump['kode_perusahaan'] !== '')
                                <li><span>Company Code :</span> <span>{{ $dump["kode_perusahaan"] }}</span></li>
                                <li><span>Payment Account Number :</span> <span>{{ $dump["account_number"] }}</span></li>
                            @else
                                <li><span>Virtual Account :</span> <span>{{ $dump["account_number"] }}</span></li>
                            @endif

                                <li><span>Admin Fee :</span> <span>Rp . {{ nominalFormat($dump["gross_amount"] - $order["total_amount"]) }}</span></li>
                                <li><span>Total Payment :</span> <span>Rp . {{ nominalFormat($dump["gross_amount"]) }}</span></li>
                        @endif

                    </ul>
                    <div class="cart-btn mt-100">
                        @if (is_null($order->paid_at))
                            <a href="#" class="btn amado-btn w-100 btn-pay">{{ $order->dump_payment ? "Change Payment" : "Pay" }}</a>
                        @else
                            <button href="#" class="btn amado-btn w-100" disabled>Your Invoice Paid</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('javascript')
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env("MIDTRANS_CLIENT_KEY") }}"></script>
    <script src="{{ asset("assets/js/do.js?v=1.0") }}"></script>
@endsection
