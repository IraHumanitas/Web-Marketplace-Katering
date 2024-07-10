<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\InvoiceController;


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
    return view('welcome');
});

Route::get('/register',[AuthController::class,'loadRegister']);
Route::post('/register',[AuthController::class,'register'])->name('register');
Route::get('/login',function(){
    return redirect('/');
});

Route::get('/',[AuthController::class,'loadLogin']);
Route::post('/login',[AuthController::class,'login'])->name('login');
Route::get('/logout',[AuthController::class,'logout']);


// ********** Merchants Routes *********
Route::group(['prefix' => 'merchant','middleware'=>['web','isMerchant']],function(){
    Route::get('/dashboard',[MerchantController::class,'dashboard']);

    Route::get('/merchant',[MerchantController::class,'users'])->name('Merchant');
    // Route::get('/manage-role',[MerchantController::class,'manageRole'])->name('manageRole');
    // Route::post('/update-role',[MerchantController::class,'updateRole'])->name('updateRole');

    // Menu
    Route::get('/menus', [MenuController::class, 'index'])->name('menus.index');
    Route::get('/menus/create', [MenuController::class, 'create'])->name('menus.create');
    Route::post('/menus/store', [MenuController::class, 'store'])->name('menus.store');
    Route::get('menus/{id}/edit', [MenuController::class, 'edit'])->name('menus.edit');
    Route::delete('menus/{id}', [MenuController::class, 'destroy'])->name('menus.destroy');
    Route::put('menus/{id}', [MenuController::class, 'update'])->name('menus.update');
    Route::get('menus/search', [MenuController::class, 'search'])->name('menus.search');

    // Profile
    Route::get('merchant/profile', [MerchantController::class, 'show'])->name('merchant.profile');
    Route::put('merchant/profile/update', [MerchantController::class, 'update'])->name('merchant.profile.update');
});

// ********** Customers Routes *********
Route::group(['prefix' => 'customer','middleware'=>['web','isCustomer']],function(){
    Route::get('/dashboard',[CustomerController::class,'dashboard']);

    Route::get('/customer',[CustomerController::class,'dashboard'])->name('customer');

    // Profile
    Route::get('customer/profile', [CustomerController::class, 'show'])->name('customer.profile');
    Route::put('customer/profile/update', [CustomerController::class, 'update'])->name('customer.profile.update');
 
    // Merchant & Menu Order
    Route::get('/merchants', [MerchantController::class, 'index'])->name('merchants.index');
    Route::get('merchant/{merchantId}/menus', [MenuController::class, 'showMenus'])->name('merchant.menus');

    // Keranjang
    Route::get('/menu/{merchantId}', [MenuController::class, 'showMenuByMerchant'])->name('menus.show');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
    Route::post('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    // Checkout
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    // Invoice
    Route::get('/invoice/{id}', [InvoiceController::class, 'show'])->name('invoice.show');

});

