<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/',[AuthController::class,'showLoginForm'])->name('show.login.form');
Route::post('/',[AuthController::class,'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::middleware('auth')->group(function(){
    Route::get('/cart',[CartController::class,'index'])->name('cart');
    Route::post('/cart/add',[CartController::class,'addToCart'])->name('add.cart');
    Route::post('/cart/remove/{id}',[CartController::class,'removeFromCart'])->name('remove.cart');
});


