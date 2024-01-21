 <!-- ##### Footer Area Start ##### -->
 <footer class="footer_area clearfix">
    <div class="container">
        <div class="row align-items-center">
            <!-- Single Widget Area -->
            <div class="col-12 col-lg-4">
                <div class="single_widget_area">
                    <!-- Logo -->
                    <div class="footer-logo mr-50">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset("assets/img/core-img/logo2.png") }}" alt="">
                        </a>
                    </div>
                    <!-- Copywrite Text -->
                    <p class="copywrite">
                        Copyright &copy;<script>document.write(new Date().getFullYear());</script> Oke Shop
                    </p>
                </div>
            </div>
            <!-- Single Widget Area -->
            <div class="col-12 col-lg-8">
                <div class="single_widget_area">
                    <!-- Footer Menu -->
                    <div class="footer_menu">
                        <nav class="navbar navbar-expand-lg justify-content-end">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#footerNavContent" aria-controls="footerNavContent" aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-bars"></i></button>
                            <div class="collapse navbar-collapse" id="footerNavContent">
                                <ul class="navbar-nav ml-auto">
                                    <li class="nav-item {{ Request::segment(1) == "" ? "active" : "" }}">
                                        <a class="nav-link" href="{{ url('/') }}">Home</a>
                                    </li>
                                    <li class="nav-item {{ Request::segment(1) == "products" ? "active" : "" }}">
                                        <a class="nav-link" href="{{ url('/products') }}">Products</a>
                                    </li>
                                    @if(\Auth::check())
                                        <li class="nav-item {{ Request::segment(1) == "products" ? "active" : "" }}">
                                            <a class="nav-link" href="javascript:;" onclick="logout()">Logout</a>
                                        </li>
                                    @else
                                        <li class="nav-item {{ Request::segment(1) == "login" ? "active" : "" }}">
                                            <a class="nav-link" href="{{ url('/login') }}" onclick="logout()">Login</a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- ##### Footer Area End ##### -->
