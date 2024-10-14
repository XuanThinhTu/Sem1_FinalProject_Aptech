
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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">

</head>
<body>
<footer class="bg-dark text-white py-5">
    <div class="container footer-center">
        <div class="row">
            <!-- Contact Information -->
            <div class="col-md-3">
                <h5>Contact Information</h5>
                <ul class="list-unstyled">
                    <li><p href="#artists" class="text-white">tudaicomtam@gmail.com</p></li>
                    <li><p href="#artists" class="text-white">+84 789 123 123</p></li>
                    <li><p href="#artists" class="text-white">facebook.com/tudaicomtam</p></li>
                </ul>
            </div>

            <!-- Quick Links -->
            <div class="col-md-3">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="#auctions" class="text-white">Auctions</a></li>
                    <li><a href="{{route('categoriespage')}}" class="text-white">Products</a></li>
                </ul>
            </div>

            <!-- Policies -->
            <div class="col-md-3">
                <h5>Policies</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-white">Privacy</a></li>
                    <li><a href="#" class="text-white">Terms</a></li>
                </ul>
            </div>

            <!-- Services -->
            <div class="col-md-3">
                <h5>Services</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-white">Contact Us</a></li>
                </ul>
            </div>


        </div>
        <hr class="my-4">
        <div class="row">
            <div class="col text-center">
                <div class="social-icons">
                    <a href="#" class="text-white me-2"><i class="ti-facebook"></i></a>
                    <a href="#" class="text-white me-2"><i class="ti-instagram"></i></a>
                    <a href="#" class="text-white me-2"><i class="ti-google"></i></a>
                </div>
                <p>&copy; 2024 ArtAuction. All rights reserved.</p>
            </div>
        </div>

    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script src="{{ asset('demo/js/index.js') }}"></script>
<script src="{{ asset('demo/js/detail.js') }}"></script>
<script src="{{ asset('demo/js/auctions.js')}}"></script>
</body>

</html>
