<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    $categoryCount = Category::count();
    $productCount = Product::count();
    $orderCount = Order::count();

    // Pass the counts to the view
    return view('dashboard', compact('categoryCount', 'productCount', 'orderCount'));
});
Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
Route::post('orders/place', [OrderController::class, 'placeOrder'])->name('orders.place');
Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
