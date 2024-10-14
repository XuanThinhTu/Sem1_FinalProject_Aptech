<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ArtAuction - Home</title>

    <!-- Roboto Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap"
        rel="stylesheet">

    <!-- Bootstrap and other styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('demo/css/galleries.css') }}">
    <link rel="stylesheet" href="{{ asset('demo/css/detail.css') }}">
    <link rel="stylesheet" href="{{ asset('demo/css/categories.css') }}">
    <link rel="stylesheet" href="{{ asset('demo/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('demo/css/auctions.css') }}">
    <link rel="stylesheet" href="{{ asset('demo/assets/themify-icons-font/themify-icons/themify-icons.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        a,
        nav {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>

<body>
    <header class="bg-white" style="position: relative;">
    <header class="bg-white" style="position: relative;">
        <div class="container d-flex justify-content-between align-items-center">
            <div></div>
            <div class="text-center">
                <h1 class="display-9" style="font-weight: 500;">
                    <a href="{{ route('homepage') }}"
                        style="text-decoration: none; color: inherit; font-size: inherit;">
                        Bid Spirit
                    </a>
                </h1>
                <h1 class="display-9" style="font-weight: 500;">
                    <a href="{{ route('homepage') }}"
                        style="text-decoration: none; color: inherit; font-size: inherit;">
                        Bid Spirit
                    </a>
                </h1>
            </div>


            <div class="d-flex align-items-center">


            <div class="d-flex align-items-center">
                @if (Auth::check())
                    <!-- Dropdown button -->
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown"
                            aria-expanded="false"
                            style="border: none; background-color: transparent; box-shadow: none;">
                            {{ Auth::user()->last_name }}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="userDropdown"
                            style="position: absolute; z-index: 1050; top: 100%; left: 0;">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item" type="submit">Log Out</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <!-- Nếu chưa đăng nhập -->
                    <!-- Nếu chưa đăng nhập -->
                    <a class="nav-link" href="{{ route('login') }}">Log In</a>
                    <span class="mx-2">or</span>
                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                @endif
            </div>
        </div>
    </header>



    <!-- begin navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('homepage') }}">Artists</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('categoriespage') }}">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('galleriespage') }}">Galleries</a>
                    </li>
                </ul>
                <!-- Search Bar -->
                <div class="search-icon ti-search" onclick="toggleSearch()"></div>
                <div class="search-container" id="search-container">
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="{{ asset('demo/js/index.js') }}"></script>
    <script src="{{ asset('demo/js/detail.js') }}"></script>
    <script src="{{ asset('demo/js/auctions.js') }}"></script>
    <script src="{{ asset('demo/js/auctions.js') }}"></script>
</body>

</html>
