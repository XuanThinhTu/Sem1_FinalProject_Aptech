<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class DetailsController extends Controller
{
    public function index($id)
    {
        // Lấy sản phẩm theo ID
        $item = Item::with('auction')->findOrFail($id);

        // Trả dữ liệu về trang chi tiết sản phẩm
        return view('pages.detailspage', compact('item'));
    }
}
