<?php

namespace App\Console;

use App\Models\Auction;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Chạy task này mỗi phút
        $schedule->call(function () {
            // Lấy tất cả các phiên đấu giá đã đến ngày kết thúc và vẫn đang active
            $auctions = Auction::where('end_date', '<=', now())
                ->where('status', 'active')
                ->get();

            foreach ($auctions as $auction) {
                // Kiểm tra bid cao nhất (nếu có)
                $highestBid = $auction->bids()->max('bid_amount');
                $endPrice = $highestBid ? $highestBid : $auction->start_price;

                // Cập nhật end_price và trạng thái của phiên đấu giá
                $auction->update([
                    'end_price' => $endPrice,
                    'status' => 'closed',
                ]);
            }
        })->everyMinute();  // Chạy mỗi phút
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
