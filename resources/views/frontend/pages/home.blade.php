@extends('frontend.layouts')
@section('title', 'Home')
@section('content')
<!-- Product Catagories Area Start -->
    <div class="products-catagories-area clearfix">
        <div class="amado-pro-catagory clearfix">

            <!-- Single Catagory -->
            @foreach($categories as $category)
                <div class="single-products-catagory clearfix">
                    <a href="{{ url("products/" . $category->slug) }}">
                        <img src="{{ $category->main_image }}"  alt="img-{{ $category->name }}">
                        <!-- Hover Content -->
                        <div class="hover-content">
                            <div class="line"></div>
                            <h4>{{ $category->name }}</h4>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
<!-- Product Catagories Area End -->
@endsection
