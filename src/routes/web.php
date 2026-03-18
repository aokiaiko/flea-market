<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\FavoriteController;



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

Route::middleware('auth')->group(function () {
    // 認証メール案内ページ（未認証でもログインしてれば見れる）
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');
    Route::get('/mypage/profile', [MypageController::class, 'edit']);
    Route::patch('/mypage/profile', [MypageController::class, 'update']);
});

Route::middleware('auth','verified')->group(function () {
    Route::get('/mypage', [MyPageController::class, 'show']);
    Route::get('/mypage/edit', [MyPageController::class, 'edit']);
    Route::get('/sell', [ItemController::class, 'create']);
    Route::post('/sell', [ItemController::class, 'store']);
    Route::post('/items/{item_id}/comments', [ItemController::class, 'storeComment']);
    Route::get('/purchase/{item_id}', [PurchaseController::class, 'create']);
    Route::post('/purchase/{item_id}', [PurchaseController::class,'store']);
    Route::post('/items/{item_id}/favorite', [FavoriteController::class, 'store']);
    Route::delete('/items/{item_id}/favorite', [FavoriteController::class, 'destroy']);
    Route::patch('/purchase/address/{item_id}', [AddressController::class, 'update']);
    Route::get('/purchase/address/{item_id}', [AddressController::class,'edit']);
});

Route::get('/', [ItemController::class,'index']);
Route::get('/item/{item_id}', [ItemController::class,'show']);

Route::get('/register', [AuthController::class,'showRegister']);
Route::post('/register', [AuthController::class,'store']);
Route::get('/login', [AuthController::class,'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);


