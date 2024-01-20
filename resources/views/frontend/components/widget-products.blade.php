<div class="shop_sidebar_area">
    <!-- ##### Single Widget ##### -->
        <div class="widget catagory mb-50">
            <!-- Widget Title -->
            <h6 class="widget-title mb-30">Category</h6>

            <!--  Catagories  -->
            <div class="catagories-menu">
                <ul>
                    <li class="{{ Request::segment(1) == "products" && !Request::segment(2) ? "active" : "" }}"><a href="{{ url('products') }}">All</a></li>
                    @forelse ($categories as $item)
                        <li class="{{ Request::segment(2) == $item->slug ? "active" : "" }}"><a href="{{ url("products/" . $item->slug) }}">{{ $item->name }}</a></li>
                    @empty

                    @endforelse
                </ul>
            </div>
        </div>
    </div>
