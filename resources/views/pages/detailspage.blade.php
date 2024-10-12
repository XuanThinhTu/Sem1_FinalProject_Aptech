@extends('layouts.main')

@section('content')
    <!-- Main Content -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <!-- Navigation -->
            <div class="col-md-8">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="nav-buttons">
                        <a href="#" class="text-muted">&larr; PREVIOUS<br>{{ $item->title }}</a>
                    </div>
                    <div class="text-center">
                        <h6 class="fw-bold mb-0">{{ $item->title }}</h6>
                        <p class="text-muted mb-0">Auction live through
                            {{ \Carbon\Carbon::parse($item->auction->end_date)->format('F j, Y') }}</p>
                    </div>
                    <div class="nav-buttons text-end">
                        <a href="#" class="text-muted">NEXT &rarr;</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <!-- Art Image -->
            <div class="col-md-5">
                <img src="{{ asset($item->image_path) }}" class="art-image" alt="{{ $item->title }}">
                <div class="text-center mt-3">
                    <a href="#" class="btn btn-outline-dark text-decoration-none" data-bs-toggle="modal"
                        data-bs-target="#imageModal">
                        <i class="bi bi-image"></i> VIEW IMAGES (5)
                    </a>
                </div>
            </div>

            <!-- Art Details -->
            <div class="col-md-5 art-details">
                <h5><a href="#" class="text-dark">{{ $item->title }}</a></h5>
                <p class="text-muted">{{ $item->category->name }}</p>
                <hr class="hr-1px">
                <h6><em>{{ $item->description }}</em></h6>
                <p>
                    Starting Price: {{ number_format($item->starting_price, 2) }} USD<br>
                    @if (\Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($item->auction->end_date)))
                        End Price: {{ number_format($item->auction->end_price, 2) }} USD<br>
                    @else
                        End Price: Auction still ongoing<br>
                    @endif
                    Auction Status: {{ $item->auction->status }}
                </p>
                <p>Ending: <span>{{ \Carbon\Carbon::parse($item->auction->end_date)->diffForHumans() }}</span></p>
                <hr class="hr-1px">
                <p>Current Bid: <span>{{ number_format($item->auction->step, 2) }} USD</span></p>

                <!-- Bid Section -->
                <div class="bid-section">
                    <label for="bidAmount" class="form-label">Enter your maximum bid*</label>
                    <input type="number" id="bidAmount" name="bidAmount" min="{{ $item->starting_price }}"
                        step="{{ $item->auction->step }}" class="form-control"
                        oninput="validateBidAmount(this.value, {{ $item->auction->step }}, {{ $item->starting_price }})"

                    <p class="mt-2 text-muted" style="font-size: 12px;">
                        Your bid: <span id="bidValue">{{ number_format($item->starting_price, 2) }} USD</span><br>
                        * This amount excludes shipping fees, applicable taxes and will have a Buyer's Premium based on
                        the hammer price of the lot. <a href="#">Buyer's Premium</a>.
                    </p>

                        <div id="bidErrorMessage" class="text-danger" style="display: none;">
                        </div>

                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <button class="btn btn-dark w-100 mb-2">PLACE BID</button>
                </div>

                <hr class="hr-1px">

                <!-- Contact Section -->
                <div class="d-flex align-items-center contact-section">
                    <img src="https://via.placeholder.com/50" alt="Susanna Wenniger" class="rounded-circle">
                    <div>
                        <p class="mb-0"><strong>Susanna Wenniger</strong></p>
                        <p class="text-muted mb-0">Head Of Photographs</p>
                        <a href="#" class="text-dark">MESSAGE SUSANNA</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateBidValue(value) {
            document.getElementById('bidValue').innerHTML = new Intl.NumberFormat().format(value) + ' USD';
        }

        function validateBidAmount(value, step, startingPrice) {
        // Chuyển đổi giá trị nhập sang số
        const bidAmount = parseFloat(value);
        const bidStep = parseFloat(step) + parseFloat(startingPrice);
        
        // Kiểm tra nếu giá trị nhỏ hơn giá khởi điểm
        if (bidAmount < bidStep) {
            document.getElementById('bidErrorMessage').style.display = 'block';
            document.getElementById('bidErrorMessage').innerHTML = 'The bid amount must be greater than the starting price.';
            document.getElementById('bidValue').innerHTML = startingPrice.toLocaleString() + ' USD';
            return;
        }
        // Kiểm tra nếu giá trị không là bội số của bước giá
        else if ((bidAmount % step !== 0) && bidAmount > startingPrice) {
            document.getElementById('bidErrorMessage').style.display = 'block';
            document.getElementById('bidErrorMessage').innerHTML = 'The bid amount must be a multiple of ' + {{ $item->auction->step }} + ' USD.'
            document.getElementById('bidValue').innerHTML = startingPrice.toLocaleString() + ' USD';
        } else {
            document.getElementById('bidErrorMessage').style.display = 'none';
            document.getElementById('bidValue').innerHTML = bidAmount.toLocaleString() + ' USD';
        }
    }
    </script>
@endsection
