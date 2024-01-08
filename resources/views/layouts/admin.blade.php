<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Dashboard Template Description" />
    <meta name="keywords" content="Dashboard Template" />
    <meta name="author" content="Rajodiya Infotech" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon" />

    <!-- font css -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">

    <!-- vendor css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('assets/css/customizer.css') }}">
</head>

<body class="theme-3">
    <!-- [ auth-signup ] start -->
    <div class="auth-wrapper auth-v3">
        <div class="bg-auth-side bg-primary"></div>
        <div class="auth-content">
            <nav class="navbar navbar-expand-md navbar-light default">
                <div class="container-fluid pe-2">
                    <a class="navbar-brand" href="#">
                        <img src="{{ asset('assets/images/logo-dark.svg') }}" alt="logo" />
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                        <ul class="navbar-nav align-items-center ms-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" href="#">Pages</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Ecommerce</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Docs</a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btn-primary ms-2 me-2" href="#">Buy now</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="card">
                <div class="row align-items-center text-start">
                    <div class="col-xl-6">
                        <div class="card-body">
                            @yield('content')
                        </div>
                    </div>
                    <div class="col-xl-6 img-card-side">
                        <div class="auth-img-content">
                            <img src="{{ asset('assets/images/auth/img-auth-3.svg') }}" alt=""
                                class="img-fluid" />
                            <h3 class="text-white mb-4 mt-5">
                                “Attention is the new currency”
                            </h3>
                            <p class="text-white">
                                The more effortless the writing looks, the more effort the
                                writer actually put into the process.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="auth-footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6">
                            <img src="{{ asset('assets/images/logo-dark.svg') }}" alt="logo" />
                        </div>
                        <div class="col-6 text-end">
                            <ul class="list-inline mb-1">
                                <li class="list-inline-item">
                                    <a href="#" class="link-light">Joseph</a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#" class="link-light">About Us</a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#" class="link-light">Blog</a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#" class="link-light">Library</a>
                                </li>
                            </ul>
                            <p class="text-white">
                                © 2022, made with love for a better web.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ auth-signup ] end -->

    <script src="{{ asset('assets/js/vendor-all.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
</body>

</html>
