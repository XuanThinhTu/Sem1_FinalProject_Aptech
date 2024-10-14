@extends('layouts.main')

@section('content')
    <main>
        <div class="container my-5">
            <!-- Top bar: View dropdown and Sort button -->
            <div class="row mb-4">
                <div class="col-6">
                    <div class="dropdown">
                        <label for="viewSelect" class="me-2">View</label>
                        <select class="form-select d-inline-block w-auto" id="viewSelect">
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                </div>
                <div class="col-6 text-end">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="sortDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Sort
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                            <li><a class="dropdown-item" href="#">Price: Low to High</a></li>
                            <li><a class="dropdown-item" href="#">Price: High to Low</a></li>
                            <li><a class="dropdown-item" href="#">Newest First</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Artwork Grid -->
            <div class="row g-4">
                @foreach ($items as $item)
                    <div class="col-md-3">
                        <div class="artwork p-3 text-center">
                            <a href="{{ route('detailspage', ['id' => $item->id]) }}">
                                <img src="{{ asset($item->image_path) }}" alt="{{ $item->title }}" class="img-fluid">
                                <div class="artwork-title">
                                    <strong
                                        style="font-size: 1rem; color: #2c3e50;">{{ $item->category->name }}</strong><br>
                                    @php
                                        $now = \Carbon\Carbon::now();
                                        $startDate = \Carbon\Carbon::parse($item->auction->start_date);
                                        $endDate = \Carbon\Carbon::parse($item->auction->end_date);
                                    @endphp
                                    @if ($now->lessThan($startDate))
                                        <span
                                            style="font-weight: bold; font-size: 1.05rem; color: #979797;">{{ $item->title }}</span><br>
                                    @elseif($now->between($startDate, $endDate))
                                        <span
                                            style="font-weight: bold; font-size: 1.05rem; color: #008425;">{{ $item->title }}</span><br>
                                    @else
                                        <span
                                            style="font-weight: bold; font-size: 1.05rem; color: #9a3300;">{{ $item->title }}</span><br>
                                    @endif
                                    {{ number_format($item->starting_price, 2) }} USD<br>
                                    @if ($item->auction)
                                        <!-- Hiển thị trạng thái đấu giá -->
                                        @if ($now->lessThan($startDate))
                                            <span class="text-muted">Coming Soon In -
                                                {{ $startDate->diffForHumans() }}</span>
                                        @elseif($now->between($startDate, $endDate))
                                            <span class="text-success">On Going - Ends in
                                                {{ $endDate->diffForHumans() }}</span>
                                        @else
                                            <span class="text-danger">Closed - {{ $endDate->diffForHumans() }}</span>
                                        @endif
                                    @else
                                        <span class="text-muted">No Auction Yet</span>
                                    @endif
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
@endsection
