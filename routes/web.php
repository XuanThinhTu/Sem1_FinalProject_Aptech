<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\GalleriesController;
use App\Http\Controllers\DetailsController;
use App\Http\Controllers\AuctionsController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\UsersController;


Route::get('/', [HomeController::class, 'index'])->name('homepage');


Route::get('/homepage', [HomeController::class, 'index'])->name('homepage');
Route::get('/auctionspage', [AuctionsController::class, 'index'])->name('auctionspage');
Route::get('/categoriespage', [CategoriesController::class, 'index'])->name('categoriespage');
Route::get('/galleriespage', [GalleriesController::class, 'index'])->name('galleriespage');
Route::get('/detailspage', [DetailsController::class, 'index'])->name('detailspage');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// After Login
// Route::get('/', function () {
//     return view('layouts.homepage');
// })->middleware(['auth', 'verified'])->name('homepage');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

// Admin session
route::get('admin/dashboard', [HomeController::class, 'dashboard'])->middleware('admin')->name('admin.dashboard');

route::get('/admin/categories', [CategoriesController::class, 'show'])->middleware('admin')->name('admin.categories');
Route::post('/categories/store', [CategoriesController::class, 'store'])->middleware('admin')->name('category.store');
Route::delete('/admin/categorie/{id}', [CategoriesController::class, 'destroy'])->name('category.destroy');
Route::get('/admin/categories/{id}/edit', [CategoriesController::class, 'edit'])->name('category.edit');
Route::put('/admin/categories/{id}', [CategoriesController::class, 'update'])->name('category.update');


// Items session
Route::get('/admin/items', [ItemsController::class, 'index'])->name('items.index');
Route::post('/admin/items/store', [ItemsController::class, 'store'])->name('items.store');
Route::get('/admin/items/{id}/edit', [ItemsController::class, 'edit'])->name('items.edit');
Route::put('/admin/items/{id}', [ItemsController::class, 'update'])->name('items.update');
Route::delete('/admin/items/{id}', [ItemsController::class, 'destroy'])->name('items.destroy');


// Users session
Route::get('/admin/users', [UsersController::class, 'index'])->name('users.index');
Route::post('/admin/users/store', [UsersController::class, 'store'])->name('users.store');
Route::get('/admin/users/{id}/edit', [UsersController::class, 'edit'])->name('users.edit');
Route::put('/admin/users/{id}', [UsersController::class, 'update'])->name('users.update');
Route::delete('/admin/users/{id}', [UsersController::class, 'destroy'])->name('users.destroy');

// Auctions session
// Route::get('/items-by-category/{id}', [AuctionsController::class, 'getItemsByCategory']);
// Route::resource('auctions', AuctionsController::class);
// Route cho hiển thị danh sách Auction
Route::get('/admin/auctions', [AuctionsController::class, 'index'])->name('auctions.index');

// Route cho form thêm Auction
Route::get('/admin/auctions/create', [AuctionsController::class, 'create'])->name('auctions.create');

// Route lưu thông tin Auction mới
Route::post('/admin/auctions/store', [AuctionsController::class, 'store'])->name('auctions.store');

// Route cho form chỉnh sửa Auction
Route::get('/admin/auctions/{id}/edit', [AuctionsController::class, 'edit'])->name('auctions.edit');

// Route cập nhật thông tin Auction
Route::put('/admin/auctions/{id}', [AuctionsController::class, 'update'])->name('auctions.update');

// Route xóa Auction
Route::delete('/admin/auctions/{id}', [AuctionsController::class, 'destroy'])->name('auctions.destroy');

// Route lấy các Items theo Category qua AJAX
Route::get('/admin/items-by-category/{categoryId}', [AuctionsController::class, 'getItemsByCategory']);
