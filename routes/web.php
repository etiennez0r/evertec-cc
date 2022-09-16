<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;

require_once app_path('Includes/Constants.php');
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $products = \App\Models\Product::all();

    return view('index', compact('products'));
});

Route::get('/cart/{productId}', function ($productId) {
    $product = \App\Models\Product::findOrFail($productId);

    return view('cart', compact('product'));
});

Route::get('/welcome', function () {
    return view('welcome');
});

Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
Route::get('/orders/all', [OrderController::class, 'index'])->name('orders.all');

Route::resource('orders', OrderController::class);

