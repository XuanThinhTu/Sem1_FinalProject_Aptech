@extends('layouts.main')

@section('content')
    <!-- Main Content -->
    <div class="container mt-5">
        <!-- Thông báo nếu có -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif(session('fail'))
        <div class="alert alert-danger">
            {{ session('fail') }}
        </div>
        @endif
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
                <img src="{{ asset($item->image_path) }}" class="art-image-ver2" alt="{{ $item->title }}">
            </div>
            <!-- Art Details -->
            <div class="col-md-5 art-details">
                <h5 href="#" class="text-dark">{{ $item->title }}</>
                </h5>
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
                <p>Current Step: <span>{{ number_format($item->auction->step, 2) }} USD</span></p>
                

                <!-- Bid Section -->
                <div class="bid-section">
                    <label for="bidAmount" class="form-label">Enter your maximum bid*</label>
                    <input type="number" id="bidAmount" name="bidAmount" min="{{ $item->starting_price }}"
                        step="{{ $item->auction->step }}" class="form-control"
                        oninput="validateBidAmount(this.value,
                        {{ $item->auction->step }}, 
                        {{ $item->starting_price }}); checkBidAmount(this); updateHiddenBid(this.value)">
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
                    @if ($item->auction->status !== 'closed' && $item->auction->status !== 'pending')
                        @auth
                            <form action="{{ route('bid.placeBid') }}" method="POST" onsubmit="updateHiddenBid(document.getElementById('bidAmount').value)">
                                @csrf
                                <!-- Hidden inputs to pass the item and category details to the payment page -->
                                <input type="hidden" name="item_id" value="{{ $item->id }}">
                                <input type="hidden" name="auction_id" value="{{ $item->auction->id }}">
                                <input type="hidden" name="item_title" value="{{ $item->title }}">
                                <input type="hidden" name="item_image" value="{{ $item->image_path }}">
                                <input type="hidden" name="item_image" value="{{ $item->image_path }}">
                                <input type="hidden" name="item_bid" id="item_bid" value="">

                                <input type="hidden" name="category_name" value="{{ $item->category->name }}">
                                <input type="hidden" name="starting_price" value="{{ $item->starting_price }}">
                                <input type="hidden" name="end_price"
                                    value="{{ $item->auction->end_price ?? $item->starting_price }}">
                                <input type="hidden" name="step" value="{{ $item->auction->step }}">

                                <button type="submit" id="placeBidButton" class="btn btn-dark w-100 mb-2" name="redirect"
                                    disabled>PLACE BID</button>
                            </form>
                            {{-- <a href="{{ route('payment') }}" class="btn btn-dark w-100 mb-2">Log in to place a bid</a> --}}
                        @else
                            <a href="{{ route('login') }}" class="btn btn-dark w-100 mb-2">Log in to place a bid</a>
                        @endauth
                    @elseif($item->auction->status == 'pending')
                        <p class="text-muted text-center">This auction has not opened.</p>
                    @else
                        <p class="text-muted text-center">This auction has ended. No more bids can be placed.</p>
                    @endif
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
            const bidStepedAmount = parseFloat(step) + parseFloat(startingPrice);
            const stepVal = bidAmount - parseFloat(startingPrice);
            const placeBidButton = document.getElementById('placeBidButton');
            // Kiểm tra nếu giá trị nhỏ hơn giá khởi điểm
            if (bidAmount < bidStepedAmount) {
                placeBidButton.disabled = true; // Disable button
                document.getElementById('bidErrorMessage').style.display = 'block';
                document.getElementById('bidErrorMessage').innerHTML =
                    'The bid amount must be greater than the starting price.';
                document.getElementById('bidValue').innerHTML = startingPrice.toLocaleString() + ' USD';
                return;
            }
            // Kiểm tra nếu giá trị không là bội số của bước giá
            else if ((stepVal % step !== 0) && bidAmount > startingPrice) {
                const placeBidButton = document.getElementById('placeBidButton');
                document.getElementById('bidErrorMessage').style.display = 'block';
                document.getElementById('bidErrorMessage').innerHTML = 'The bid amount must be a multiple of ' +
                    {{ $item->auction->step }} + ' USD.'
                document.getElementById('bidValue').innerHTML = startingPrice.toLocaleString() + ' USD';
            } else {
                placeBidButton.disabled = false;
                document.getElementById('bidErrorMessage').style.display = 'none';
                document.getElementById('bidValue').innerHTML = bidAmount.toLocaleString() + ' USD';
            }
        }

        function updateHiddenBid(bid) {
            document.getElementById('item_bid').value = bid;
        }
    </script>
@endsection
