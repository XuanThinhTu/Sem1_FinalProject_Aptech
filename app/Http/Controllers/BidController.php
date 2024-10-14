<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Bid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BidController extends Controller
{
    public function placeBid(Request $request)
    {
        $user_id = Auth::user()->id; // Lấy user hiện tại
        $auction_id = $request->input('auction_id'); // Lấy auction_id từ request
        $item_bid = $request->input('item_bid'); // Lấy số tiền bid từ request
        // Tìm auction theo auction_id
        $auction = Auction::find($auction_id);

        if (!$auction) {
            return redirect()->back()->withErrors(['msg' => 'Auction not found']);
        }
        // Tìm bid cao nhất hiện tại của auction
        $highestBid = Bid::where('auction_id', $auction_id)->max('bid_amount');
        if (is_null($highestBid)) {
            $highestBid = $auction->start_price;
        }
        // Kiểm tra nếu bid của user nhỏ hơn bid cao nhất hiện tại
        if ($item_bid <= $highestBid) {
            return redirect()->back()->with(['fail' => 'Your bid must be higher than the current highest bid of ' . number_format($highestBid, 2) . ' USD']);
        } else {
            // Kiểm tra nếu user đã đặt bid cho auction này chưa
            $existingBid = Bid::where('user_id', $user_id)
                ->where('auction_id', $auction_id)
                ->first();

            if ($existingBid) {
                // User đã đặt bid
                Bid::create([
                    'auction_id' => $auction_id,
                    'user_id' => $user_id,
                    'bid_amount' => $item_bid,
                ]);

                return redirect()->back()->with('success', 'Bid updated successfully!');
            } else {
                // Đây là lần đầu tiên user đặt bid cho auction này, tạo mới và chuyển đến thanh toán
                Bid::create([
                    'auction_id' => $auction_id,
                    'user_id' => $user_id,
                    'bid_amount' => $item_bid,
                ]);
                // Điều hướng đến trang thanh toán VNPay
                return view('pages.redirectVNPAY', [
                    'id' => $request->input('item_id'),
                    'auction_id' => $auction_id,
                    'item_bid' => $item_bid,
                    'start_price' => $request->input('starting_price'),
                ]);
            }
        }

    }

    public function success()
    {
        return view('auctions.success');
    }

    public function failed()
    {
        return view('auctions.failed');
    }

}
