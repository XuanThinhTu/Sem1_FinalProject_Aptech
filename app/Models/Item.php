<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    /**
     * Các thuộc tính có thể thêm/sửa.
     *
     * @var array
     */
    protected $fillable = [
        'id'
        'title',
        'description',
        'starting_price',
        'category_id',
        'bid_count',
        'image_path'
    ];

    /**
     * Quan hệ với bảng Category.
     * Mỗi Item thuộc về một Category.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

  
    /**
     * Quan hệ với bảng Bid.
     * Mỗi Item có nhiều lượt đặt giá (Bids).
     */
    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    /**
     * Accessor để tính tổng bid_amount.
     * Sử dụng: $item->bid_count.
     */
    public function getBidCountAttribute()
    {
        return $this->bids()->sum('bid_amount');
      
    // Quan hệ với bảng User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function auction()
    {
        return $this->hasOne(Auction::class);
    }
}
