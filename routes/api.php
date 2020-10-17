<?php

use App\Http\Controllers\BasketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get("/basket/add/{sku}", [BasketController::class, "addItem"]);
Route::get("/basket/add/{sku}/{amount}", [BasketController::class, "addItem"])
    ->where("amount", "[0-9]+");

Route::get("/basket/change_amount/{sku}/{amount}", [BasketController::class, "changeItemAmount"])
    ->where("amount", "[0-9]+");

Route::get("/basket/remove/{sku}", [BasketController::class, "removeItem"]);
Route::get("/basket/remove_all/", [BasketController::class, "removeAll"]);

Route::get("/basket/get_list/", [BasketController::class, "getList"]);


