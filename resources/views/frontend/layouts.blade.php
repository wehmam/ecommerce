<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title  -->
    <title>@yield('title')</title>

    <!-- Favicon  -->
    {{-- <link rel="icon" href="{{ asset("assets/img/core-img/favicon.ico") }}"> --}}
    <link rel="icon" href="{{ asset('assets/img/Logo.png') }}">

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="{{ asset("assets/css/core-style.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/style.css") }}">
    
    @yield('css')
</head>

<body>
    <!-- Search Wrapper Area Start -->
    <div class="search-wrapper section-padding-100">
        <div class="search-close">
            <i class="fa fa-close" aria-hidden="true"></i>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="search-content">
                        <form action="{{ url("/products") }}" method="get">
                            <input type="search" name="keyword" id="search" placeholder="Type your Keyword Product ...">
                            <button type="submit"><img src="{{ asset("assets/img/core-img/search.png") }}" alt=""></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Search Wrapper Area End -->

    <!-- ##### Main Content Wrapper Start ##### -->
    <div class="main-content-wrapper d-flex clearfix">

        @include('frontend.components.mobile-nav')

        @include('frontend.components.header')

        @yield('content')

    </div>
    <!-- ##### Main Content Wrapper End ##### -->

    <!-- ##### Newsletter Area Start ##### -->
        {{-- <section class="newsletter-area section-padding-100-0">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Newsletter Text -->
                    <div class="col-12 col-lg-6 col-xl-7">
                        <div class="newsletter-text mb-100">
                            <h2>Subscribe for a <span>25% Discount</span></h2>
                            <p>Nulla ac convallis lorem, eget euismod nisl. Donec in libero sit amet mi vulputate consectetur. Donec auctor interdum purus, ac finibus massa bibendum nec.</p>
                        </div>
                    </div>
                    <!-- Newsletter Form -->
                    <div class="col-12 col-lg-6 col-xl-5">
                        <div class="newsletter-form mb-100">
                            <form action="#" method="post">
                                <input type="email" name="email" class="nl-email" placeholder="Your E-mail">
                                <input type="submit" value="Subscribe">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section> --}}
    <!-- ##### Newsletter Area End ##### -->

    @include('frontend.components.footer')


    <!-- ##### jQuery (Necessary for All JavaScript Plugins) ##### -->
    <script src="{{ asset("assets/js/jquery/jquery-2.2.4.min.js") }}"></script>
    <!-- Popper js -->
    <script src="{{ asset("assets/js/popper.min.js") }}"></script>
    <!-- Bootstrap js -->
    <script src="{{ asset("assets/js/bootstrap.min.js") }}"></script>
    <!-- Plugins js -->
    <script src="{{ asset("assets/js/plugins.js") }}"></script>
    {{-- Sweetalert --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Active js -->
    <script src="{{ asset("assets/js/active.js") }}"></script>

    @yield('javascript')
    <script>
        const sessionStatus  = "{{ Session::has('status') }}"
        const sessionMessage = "{{ Session::get('status') }}"
        const sessionClass   = "{{ Session::get('alert-class') }}"

        if(sessionStatus) {
            Swal.fire(
                sessionClass == "danger" ? "Opps!" : "Success!" ,
                sessionMessage,
                sessionClass
            )
        }

        function logout() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't Logout!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Logout!'
                }).then((result) => {
                if (result.isConfirmed) {
                    fetch('{{ url("/logout") }}', {
                        headers: {
                            'content-type'      : 'application/json',
                            'Accept'            : 'application/json',
                            'X-Requested-With'  : 'XMLHttpRequest',
                            'X-CSRF-Token'      : '{{ csrf_token() }}'
                        },
                        method: 'POST',
                    })
                    .then(res => {
                        window.location.reload()
                    })
                }
            })
        }
    </script>

</body>

</html>
