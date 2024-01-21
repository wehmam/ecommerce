@extends('frontend.layouts')
@section('title', 'Invoice List')
@section('content')
<div class="cart-table-area section-padding-100">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="cart-title mt-50">
                    <h2>Invoice List</h2>
                </div>

                <div class="cart-table clearfix">
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th>Invoice No</th>
                                <th>Total Price</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $item)
                                <tr>
                                    <td class="cart_product_desc">
                                        <h5>
                                            {{ $item->invoice_no ?? "-" }}
                                        </h5>
                                    </td>
                                    <td class="price">
                                        <span id="priceProduct">
                                            Rp . {{ nominalFormat($item->total_amount) }}
                                        </span>
                                    </td>
                                    <td class="statusPaid">
                                        <span id="statusPaid">
                                            {{ $item->status_paid }}
                                        </span>
                                    </td>
                                    <td class="buttonAction">
                                        <span id="buttonAction">
                                            <a href="{{ url('payment/' . $item->invoice_no) }}" class="btn btn-md btn-info" target="_blank">{{ !is_null($item->paid_at) ? "Detail" : "Paid" }}</a>
                                        </span>
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
        </div>
    </div>
</div>
@endsection
