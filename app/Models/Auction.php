<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    use HasFactory;

    /**
     * Các thuộc tính có thể thêm/sửa.
     *
     * @var array
     */
    protected $fillable = [
        'item_id',
        'category_id',
        'start_price',
        'end_price',
        'step',
        'start_date',
        'end_date',
        'status',
    ];

    /**
     * Quan hệ với bảng Item.
     * Mỗi phiên đấu giá (Auction) thuộc về một Item.
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }



    /**
     * Quan hệ với bảng Bid.
     * Mỗi phiên đấu giá có nhiều lượt đặt giá (Bids).
     */
    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    /**
     * Quan hệ với bảng Payment.
     * Mỗi phiên đấu giá có thể có một payment.
     */
    public function payments()
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Tính tổng số tiền bid cho phiên đấu giá này.
     *
     * @return float
     */
    public function totalBidAmount()
    {
        return $this->bids()->sum('bid_amount');
    }

    /**
     * Đếm số lượt bid trong phiên đấu giá này.
     *
     * @return int
     */
    public function bidCount()
    {
        return $this->bids()->count();
    }

    /**
     * Kiểm tra xem phiên đấu giá có đang hoạt động không.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->status === 'active';
    }
}
