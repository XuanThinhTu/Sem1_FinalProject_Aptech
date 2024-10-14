@extends('layouts.main')

@section('content')
<div class="container">
    <h2>Redirecting to VNPay...</h2>
    <form id="vnpayForm" action="{{ route('payment') }}" method="POST">
        @csrf
        <!-- Hidden inputs to pass the auction and bid details to VNPay -->
        <input type="hidden" name="item_id" value="{{ $id }}">
        <input type="hidden" name="auction_id" value="{{ $auction_id }}">
        <input type="hidden" name="item_bid" value="{{ $item_bid }}">
        <input type="hidden" name="starting_price" value="{{ $start_price }}">

        <!-- You can add more fields if necessary -->
        
        <button type="submit" name="redirect" style="display:none;">Submit</button>
    </form>

    <script>
        // Tự động submit form để chuyển đến VNPay
        document.getElementById('vnpayForm').submit();
    </script>
</div>
@endsection
