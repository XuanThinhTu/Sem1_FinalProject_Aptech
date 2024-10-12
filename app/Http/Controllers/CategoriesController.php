<?php
namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Auction;
use Carbon\Carbon; // Sử dụng đúng namespace của Carbon
use Illuminate\Http\Request;
use App\Models\Category;

class CategoriesController extends Controller
{
    public function index()
    {
        // Lấy tất cả các items kèm theo thông tin phiên đấu giá
        $items = Item::with('auction')->get();

        // Lặp qua các item để tính toán thời gian đấu giá và trạng thái
        foreach ($items as $item) {
            $auction = $item->auction; // Mỗi item có một auction liên kết

            if ($auction) {
                $now = Carbon::now();

                // Chuyển đổi start_date và end_date thành đối tượng Carbon
                $startDate = Carbon::parse($auction->start_date);
                $endDate = Carbon::parse($auction->end_date);

                // Kiểm tra nếu đấu giá đã kết thúc
                if ($now->greaterThan($endDate)) {
                    // Cập nhật trạng thái đấu giá nếu nó vẫn đang 'active'
                    if ($auction->status == 'active') {
                        $auction->status = 'closed';
                        $auction->save();
                    }
                }
                // Kiểm tra nếu đấu giá đang diễn ra
                elseif ($now->greaterThan($startDate) && $now->lessThan($endDate)) {
                    if ($auction->status == 'pending') {
                        $auction->status = 'active';
                        $auction->save();
                    }
                }
                // Đấu giá chưa bắt đầu
                else {
                    if ($auction->status != 'pending') {
                        $auction->status = 'pending';
                        $auction->save();
                    }
                }
            }
        }

        // Truyền dữ liệu đã xử lý vào view
        return view('pages.categoriespage', compact('items'));
    }


    public function store(Request $request)
    {
        // Validate dữ liệu nhập vào
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
        ]);

        // Lưu category mới vào database
        Category::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Chuyển hướng lại với thông báo thành công
        return redirect()->back()->with('success', 'Category added successfully!');
    }

    // Hiển thị danh sách categories
    public function show()
    {
        $categories = Category::all(); // Lấy tất cả categories từ database
        return view('admin.category.index', compact('categories')); // Truyền dữ liệu categories đến view
    }

    // Xóa một category
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.categories')->with('success', 'Category deleted successfully');
    }

    // Hiển thị form chỉnh sửa category
    public function edit($id)
    {
        $category = Category::findOrFail($id); // Lấy category theo id
        return view('admin.category.edit', compact('category')); // Trả về view với dữ liệu category
    }

    // Cập nhật dữ liệu category
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.categories')->with('success', 'Category updated successfully!');
    }
}
