<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auction;
use App\Models\Category;
use App\Models\Item;

class AuctionsController extends Controller
{
    // Hiển thị danh sách auctions
    public function index()
    {
        $auctions = Auction::with('item', 'item.category')->get();
        return view('admin.auction.index', compact('auctions'));
    }

    // Hiển thị form thêm mới auction
    public function create()
    {
        $categories = Category::all();
        return view('admin.auction.create', compact('categories'));
    }

    // Lưu auction mới
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'item_id' => 'required|exists:items,id',
            'start_price' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'status' => 'required|in:pending,active,closed',
            'step' => 'required|numeric|min:0.01'
        ]);

        Auction::create([
            'category_id' => $request->category_id,
            'item_id' => $request->item_id,
            'start_price' => $request->start_price,
            'end_price' => $request->start_price,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
            'step' => $request->step
        ]);

        return redirect()->route('auctions.index')->with('success', 'Auction added successfully!');
    }



    // Hiển thị form chỉnh sửa auction
    public function edit($id)
    {
        $auction = Auction::findOrFail($id);
        $categories = Category::all();
        $items = Item::where('category_id', $auction->item->category_id)->get();
        return view('admin.auction.edit', compact('auction', 'categories', 'items'));
    }

    // Cập nhật auction
    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'item_id' => 'required|exists:items,id',
            'start_price' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'status' => 'required|in:pending,active,closed',
        ]);

        $auction = Auction::findOrFail($id);
        $auction->update($request->all());

        return redirect()->route('auctions.index')->with('success', 'Auction updated successfully!');
    }

    // Xóa auction
    public function destroy($id)
    {
        $auction = Auction::findOrFail($id);
        $auction->delete();

        return redirect()->route('auctions.index')->with('success', 'Auction deleted successfully!');
    }

    // Lấy items theo category qua AJAX
    public function getItemsByCategory($categoryId)
    {
        $items = Item::where('category_id', $categoryId)->get();
        return response()->json($items);
    }
}
