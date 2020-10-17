<?php

use App\Http\Controllers\BasketController;
use Illuminate\Support\Facades\Route;

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
    return view('pages.index');
})->name("index");

Route::get("/product-details/{sku}", [BasketController::class, "productDetails"])
    ->name("product-details");

Route::get("/basket", [BasketController::class, "basket"])->name("basket");
