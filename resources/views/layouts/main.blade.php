<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ArtAuction - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('demo/css/galleries.css') }}">
    <link rel="stylesheet" href="{{ asset('demo/css/detail.css') }}">
    <link rel="stylesheet" href="{{ asset('demo/css/categories.css') }}">
    <link rel="stylesheet" href="{{ asset('demo/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('demo/css/auctions.css') }}">
    <link rel="stylesheet" href="{{ asset('demo/assets/themify-icons-font/themify-icons/themify-icons.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Open+Sans:wght@400;700&display=swap"
        rel="stylesheet">
    <style>
        .payment-method {
            margin: 0 auto;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            max-width: 150px;
        }

        .payment-method img {
            max-width: 100%;
            height: auto;
        }

        input.form-control-lg {
            height: 50px;
            /* Điều chỉnh chiều cao cho các ô nhập */
        }

        .border {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            background-color: #f9f9f9;
        }

        h5 {
            font-weight: bold;
        }

        input.form-control {
            height: 45px;
        }

        button.btn-primary {
            background-color: #007bff;
            border: none;
            height: 45px;
            font-size: 16px;
        }

        .text-center {
            text-align: center;
        }

        .art-image {
            margin: 0px 0px 15px 0px !important;
            /* Bắt buộc phải áp dụng margin là 0 */
        }

        .art-image-ver2 {
            display: block;
            margin: 140px auto 40px auto !important;
            /* Bắt buộc phải áp dụng margin là 0 */
            max-width: 100%;
            height:auto;
            width: 100%;
            object-fit: cover;
        }
    </style>
</head>

<body>
    {{-- file chính --}}
    @include('layouts.header')

    <!-- begin banner -->
    @yield('content')
    {{-- begin footer --}}

    @include('layouts.footer')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="{{ asset('demo/js/index.js') }}"></script>
    <script src="{{ asset('demo/js/auctions.js') }}"></script>
    <script src="{{ asset('demo/js/detail.js') }}"></script>
    @yield('scripts')
</body>

</html>
