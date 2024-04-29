<!DOCTYPE html>
<html class="no-js" lang="en_AU" />

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title> {{ env('APP_NAME') }} @yield('title')</title>
    <meta name="description" content="" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="HandheldFriendly" content="True" />
    <meta name="pinterest" content="nopin" />
    <meta property="og:locale" content="en_AU" />
    <meta property="og:type" content="website" />
    <meta property="fb:admins" content="" />
    <meta property="fb:app_id" content="" />
    <meta property="og:site_name" content="" />
    <meta property="og:title" content="" />
    <meta property="og:description" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:width" content="" />
    <meta property="og:image:height" content="" />
    <meta property="og:image:alt" content="" />

    <meta name="twitter:title" content="" />
    <meta name="twitter:site" content="" />
    <meta name="twitter:description" content="" />
    <meta name="twitter:image" content="" />
    <meta name="twitter:image:alt" content="" />
    <meta name="twitter:card" content="summary_large_image" />


    <link rel="stylesheet" type="text/css" href="{{ asset('css/slick.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/slick-theme.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/video-js.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;500&family=Raleway:ital,wght@0,400;0,600;0,800;1,200&family=Roboto+Condensed:wght@400;700&family=Roboto:wght@300;400;700;900&display=swap"
        rel="stylesheet">

    <!-- Fav Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="#" />
</head>

<body data-instant-intensity="mousedown">
    <div class="bg-dark top-header">
        <div class="container">
            <div class="align-items-center d-none d-lg-flex justify-content-between">
                <div class="d-flex">
                    <a href="" class="text-light text-decoration-none nav-link"><i
                            class="fab fa-facebook"></i></a>
                    <a href="" class="text-light text-decoration-none nav-link"><i class="fab fa-google"></i></a>
                    <a href="" class="text-light text-decoration-none nav-link"><i
                            class="fab fa-twitter"></i></a>
                </div>
                <div class="d-flex">
                    <a href="{{ route('home') }}" class="text-light text-decoration-none nav-link">Home</a>
                    <a href="{{ route('news.index') }}" class="text-light text-decoration-none nav-link">News</a>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-light top-header">
        <div class="container">
            <div class="row align-items-center py-3 d-none d-lg-flex justify-content-between">
                <div class="col-lg-4 logo">
                    <a href="{{ route('home') }}" class="text-decoration-none">
                        <span class="h1 text-uppercase text-primary bg-dark px-2">Online</span>
                        <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">SHOP</span>
                    </a>
                </div>
                <div class="col-lg-6 col-6 text-left  d-flex justify-content-end align-items-center">
                    @if (session()->has('is_login'))
                        <a href="{{ route('account') }}" class="nav-link text-dark">My Account
                            {{ isset($customer) ? "($customer->name)" : '' }}</a>
                    @else
                        <a href="{{ route('login') }}" class="nav-link text-dark">Login</a>/
                        <a href="{{ route('register') }}" class="nav-link text-dark">Register</a>
                    @endif
                    <form action="{{ route('shop.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" placeholder="Search For Products" name="search_product"
                                value="{{ request()->search_product }}" class="form-control"
                                aria-label="Amount (to the nearest dollar)">
                            <button type="submit" class="input-group-text primary">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <header class="bg-dark">
        <div class="container">
            <nav class="navbar navbar-expand-xl" id="navbar">
                <a href="{{ route('home') }}" class="text-decoration-none mobile-logo">
                    <span class="h2 text-uppercase text-primary bg-dark">Online</span>
                    <span class="h2 text-uppercase text-white px-2">SHOP</span>
                </a>
                <button class="navbar-toggler menu-btn" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <i class="navbar-toggler-icon fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        @foreach ($categoriesShow as $category)
                            <li class="nav-item dropdown">
                                <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    {{ $category->name }}
                                </button>
                                @if ($category->children->count() > 0)
                                    <ul class="dropdown-menu dropdown-menu-dark">
                                        @foreach ($category->children as $categoryChild)
                                            <li><a class="dropdown-item nav-link"
                                                    href="{{ route('shop.index', [$category->slug, $categoryChild->slug]) }}">{{ $categoryChild->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach


                    </ul>
                </div>
                <div class="right-nav py-0">
                    <a href="{{ route('cart.index') }}" class="ml-3 d-flex pt-2">
                        <i class="fas fa-shopping-cart text-primary"></i>
                    </a>
                </div>
            </nav>
        </div>
    </header>
    @yield('content')
    {{-- Footer --}}
    <footer class="bg-dark mt-5">
        <div class="container pb-5 pt-3">
            <div class="row">
                <div class="col-md-4">
                    <div class="footer-card">
                        <h3>Get In Touch</h3>
                        <p>No dolore ipsum accusam no lorem. <br>
                            123 Street, New York, USA <br>
                            exampl@example.com <br>
                            000 000 0000</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="footer-card">
                        <h3>Important Links</h3>
                        @if ($pages->isNotEmpty())
                            <ul>
                                @foreach ($pages as $page)
                                    <li><a href="{{ route('page.detail', $page->slug) }}" title="{{ $page->title }}">{{ $page->title }}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="footer-card">
                        <h3>My Account</h3>
                        <ul>
                            @if (session()->has('is_login'))
                                <li><a href="{{ route('account.wishlist') }}" title="Login">Wishlist</a></li>
                                <li><a href="{{ route('account') }}" title="Register">My Profile</a></li>
                                <li><a href="{{ route('account.myOrder') }}" title="My Orders">My Orders</a></li>
                            @else
                                <li><a href="{{ route('login') }}" title="Login">Login</a></li>
                                <li><a href="{{ route('register') }}" title="Register">Register</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-area">
            <div class="container">
                <div class="row">
                    <div class="col-12 mt-3">
                        <div class="copy-right text-center">
                            <p>© Copyright 2022 Amazing Shop. All Rights Reserved</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.5.1.3.min.js') }}"></script>
    <script src="{{ asset('js/instantpages.5.1.0.min.js') }}"></script>
    <script src="{{ asset('js/lazyload.17.6.0.min.js') }}"></script>
    <script src="{{ asset('js/slick.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('admin/assets/js/sweetalert/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
        window.onscroll = function() {
            myFunction()
        };

        var navbar = document.getElementById("navbar");
        var sticky = navbar.offsetTop;

        function myFunction() {
            if (window.pageYOffset >= sticky) {
                navbar.classList.add("sticky")
            } else {
                navbar.classList.remove("sticky");
            }
        }
    </script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function addWishList(id) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('account.wishlistAdd') }}',
                data: {
                    id: id
                },
                success: function(response) {
                    if (response.status == true) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: response.mess,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                    if (response.status == false) {
                        Swal.fire({
                            position: "center",
                            icon: "warning",
                            title: response.mess,
                            showConfirmButton: true,
                            // timer: 1500
                        });
                    }
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 401) {
                        // Chuyển hướng sang trang đăng nhập
                        Swal.fire({
                            title: "Please login!",
                            text: "Please log in to be added to your wish list!",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Yes, login!"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '{{ route('login') }}';
                            }
                        });

                    } else {
                        // Xử lý lỗi khác
                    }
                }
            });
        }

        function addToCart(id) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('cart.add') }}',
                data: {
                    id: id
                },
                success: function(response) {
                    if (response.status == true) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: response.mess,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                    if (response.status == false) {
                        Swal.fire({
                            position: "center",
                            icon: "warning",
                            title: response.mess,
                            showConfirmButton: true,
                            // timer: 1500
                        });
                    }
                }
            });
        }
    </script>
    @yield('js')
</body>

</html>
