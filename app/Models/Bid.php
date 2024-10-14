<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    use HasFactory;

    protected $table = 'bids';

    protected $fillable = [
        'auction_id',
        'user_id',
        'bid_amount'
    ];

    // Liên kết tới model Auction
    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }

    // Liên kết tới model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function item()
    {
        return $this->hasOneThrough(Item::class, Auction::class, 'id', 'id', 'auction_id', 'item_id');
    }

    
}
