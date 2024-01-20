@extends("backend.layouts")
@section("title", "Dashboard")
@section("content-title", "Product Detail")
@section('css')
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
@endsection
@section("content")
     <!-- Begin Page Content -->
     <div class="container-fluid">

        <!-- Page Heading -->
        <p class="mb-4">Product Detail ({{ $product->title }}) <span><a href="{{ url("/backend/product/" . $product->id . "/edit") }}" class="btn btn-sm btn-info float-right">Edit</a></span></p>

        <!-- Content Row -->
        <div class="row">

            <div class="col-xl-12 col-lg-10">

                <!-- Product Detail -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Details</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                Title : {{ $product->title }}
                            </li>
                            <li class="list-group-item">
                                Category : {{ $product->category ? $product->category->name : ""  }}
                            </li>
                            <li class="list-group-item">
                                Quantity : {{ $product->qty }} Pcs
                            </li>
                            <li class="list-group-item">
                                Price : Rp.{{ number_format($product->price, 0) }}
                            </li>
                            <li class="list-group-item">
                                Is Active : <a class="badge badge-{{ $product->is_active ? "success" : "danger" }}">{{ $product->is_active ? "Yes" : "No" }}</a>
                            </li>
                          </ul>
                    </div>
                </div>

                <!-- Bar Chart -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Product Photos</h6>
                    </div>
                    <div class="card-body">
                        @if($product->productPhotos)
                            <div class="card-columns">
                                @foreach ($product->productPhotos as $item)
                                    <div class="card">
                                        <img class="card-img"  src="{{ Storage::url($item->image) }}" alt="Card image">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- <!-- Donut Chart -->
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Donut Chart</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-pie pt-4">
                            <canvas id="myPieChart"></canvas>
                        </div>
                        <hr>
                        Styling for the donut chart can be found in the
                        <code>/js/demo/chart-pie-demo.js</code> file.
                    </div>
                </div>
            </div> --}}
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection
