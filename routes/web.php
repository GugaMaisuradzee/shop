<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('products',ProductController::class)->middleware('auth');

Route::post('/create','CartController@addProductInCart');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('products/{product}/add-to-cart',[CartController::class,'addProductInCart'])->name('addProductInCart');
    Route::post('products/{product}/remove-from-cart',[CartController::class,'removeProductFromCart'])->name('removeProductFromCart');
    Route::post('products/{product}/quantity/{quantity}',[CartController::class,'setCartProductQuantity'])->name('setCartProductQuantity');
    Route::get('cart',[CartController::class,'getUserCart'])->name('getUserCart');

});



require __DIR__.'/auth.php';
