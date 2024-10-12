<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];
    // Nếu bạn không dùng `created_at` và `updated_at`, có thể tắt timestamps
    public $timestamps = false; // Nếu không muốn dùng created_at và updated_at

    // Quan hệ với bảng Item
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
