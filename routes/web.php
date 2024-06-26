<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\Customer;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::prefix('')->group(function(){
    Route::get('/', [HomeController::class,'index'])->name('home');
    Route::get('/shop', [ShopController::class,'index'])->name('shop');
    Route::get('/category/{id}', [ShopController::class,'showByCategory'])->name('showByCategory');
    Route::get('/brand/{cate}/{id}', [ShopController::class,'showByBrand'])->name('showByBrand');
    Route::get('/product/{id}', [ShopController::class,'getProductDetail'])->name('product.detail');
});

Route::prefix('information')->group(function(){
    Route::get('/', [CustomerController::class,'index'])->name('information');
    Route::get('/orders', [CustomerController::class,'orders'])->name('orders');
    Route::get('/orders-detail/{id}', [CustomerController::class,'orderDetail'])->name('orders.detail');
    Route::get('/edit', [CustomerController::class,'edit']);
    Route::post('/update/{id}', [CustomerController::class,'update'])->name('information.update');
});

Route::prefix('cart')->middleware('checkCartLogin')->group(function(){
    Route::post('/store', [CartController::class,'store'])->name('cart.store');
    Route::post('/update', [CartController::class,'update'])->name('cart.update');
    Route::get('/delete/{id}', [CartController::class,'delete'])->name('cart.delete');
    Route::get('/', [CartController::class,'index'])->name('cart');
    Route::post('/apply-coupon', [CartController::class,'applyCoupon'])->name('cart.coupon');
    Route::get('/delete-coupon', [CartController::class,'removeCoupon'])->name('cart.coupon.delete');
    Route::prefix('/checkout')->group(function(){
        Route::get('/', [CartController::class,'checkout'])->name('cart.checkout');
        Route::post('/create-order', [CartController::class,'createOrder'])->name('cart.order.create');
    });
    

});

Route::get('/login', [UserController::class,'login'])->name('login');
Route::post('/login', [UserController::class,'post_login']);
Route::get('/loginadmin', [UserController::class,'loginadmin'])->name('loginadmin');
Route::post('/loginadmin', [UserController::class,'post_loginadmin']);
Route::get('/register', [UserController::class,'register'])->name('register');
Route::post('/register', [UserController::class,'post_register']);
Route::get('/logout', [UserController::class,'logout'])->name('logout');

Route::prefix('admin')->middleware('checkrole')->group(function () {
    Route::get('/', [AdminController::class,'index'])->name('admin');
    Route::prefix('category')->group(function () {
        Route::get('/', [CategoryController::class,'index'])->middleware('checkpermission:show-category')->name('category.index');
        Route::get('/create', [CategoryController::class,'create'])->middleware('checkpermission:create-category')->name('category.create');
        Route::post('/store', [CategoryController::class,'store'])->name('category.store');
        Route::get('/edit/{id}', [CategoryController::class,'edit'])->middleware('checkpermission:update-category')->name('category.edit');
        Route::post('/update/{id}', [CategoryController::class,'update'])->name('category.update');
        Route::get('/delete/{id}', [CategoryController::class,'delete'])->middleware('checkpermission:delete-category')->name('category.delete');
    });
    Route::prefix('brand')->group(function () {
        Route::get('/', [BrandController::class,'index'])->name('brand.index');
        Route::get('/create', [BrandController::class,'create'])->name('brand.create');
        Route::post('/store', [BrandController::class,'store'])->name('brand.store');
        Route::get('/edit/{id}', [BrandController::class,'edit'])->name('brand.edit');
        Route::post('/update/{id}', [BrandController::class,'update'])->name('brand.update');
        Route::get('/delete/{id}', [BrandController::class,'delete'])->name('brand.delete');
    });

    Route::prefix('banner')->group(function () {
        Route::get('/', [BannerController::class,'index'])->name('banner.index');
        Route::get('/create', [BannerController::class,'create'])->name('banner.create');
        Route::post('/store', [BannerController::class,'store'])->name('banner.store');
        Route::get('/edit/{id}', [BannerController::class,'edit'])->name('banner.edit');
        Route::post('/update/{id}', [BannerController::class,'update'])->name('banner.update');
        Route::get('/delete/{id}', [BannerController::class,'delete'])->name('banner.delete');
    });

    Route::prefix('product')->group(function () {
        Route::get('/', [ProductController::class,'index'])->middleware('checkpermission:show-product')->name('product.index');
        Route::get('/create', [ProductController::class,'create'])->middleware('checkpermission:create-product')->name('product.create');
        Route::post('/store', [ProductController::class,'store'])->name('product.store');
        Route::get('/edit/{id}', [ProductController::class,'edit'])->middleware('checkpermission:update-product')->name('product.edit');
        Route::post('/update/{id}', [ProductController::class,'update'])->name('product.update');
        Route::get('/delete/{id}', [ProductController::class,'delete'])->middleware('checkpermission:delete-product')->name('product.delete');
    });

    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class,'index'])->middleware('checkpermission:show-user')->name('user.index');
        Route::get('/create', [UserController::class,'create'])->middleware('checkpermission:create-user')->name('user.create');
        Route::post('/store', [UserController::class,'store'])->name('user.store');
        Route::get('/edit/{id}', [UserController::class,'edit'])->middleware('checkpermission:update-user')->name('user.edit');
        Route::post('/update/{id}', [UserController::class,'update'])->name('user.update');
        Route::get('/delete/{id}', [UserController::class,'delete'])->middleware('checkpermission:delete-user')->name('user.delete');
    });

    Route::prefix('role')->group(function () {
        Route::get('/', [RoleController::class,'index'])->middleware('checkpermission:show-role')->name('role.index');
        Route::get('/create', [RoleController::class,'create'])->middleware('checkpermission:create-role')->name('role.create');
        Route::post('/store', [RoleController::class,'store'])->name('role.store');
        Route::get('/edit/{id}', [RoleController::class,'edit'])->middleware('checkpermission:update-role')->name('role.edit');
        Route::post('/update/{id}', [RoleController::class,'update'])->name('role.update');
        Route::get('/delete/{id}', [RoleController::class,'delete'])->middleware('checkpermission:delete-role')->name('role.delete');
    });

    Route::prefix('coupon')->group(function () {
        Route::get('/', [CouponController::class,'index'])->middleware('checkpermission:show-coupon')->name('coupon.index');
        Route::get('/create', [CouponController::class,'create'])->middleware('checkpermission:create-coupon')->name('coupon.create');
        Route::post('/store', [CouponController::class,'store'])->name('coupon.store');
        Route::get('/edit/{id}', [CouponController::class,'edit'])->middleware('checkpermission:update-coupon')->name('coupon.edit');
        Route::post('/update/{id}', [CouponController::class,'update'])->name('coupon.update');
        Route::get('/delete/{id}', [CouponController::class,'delete'])->middleware('checkpermission:delete-coupon')->name('coupon.delete');
    });

    Route::prefix('order')->group(function () {
        Route::get('/', [OrderController::class,'index'])->middleware('checkpermission:list-order')->name('order.index');
        Route::get('/detail/{id}', [OrderController::class,'detail'])->middleware('checkpermission:update-order-status')->name('order.detail');
        Route::post('/update/{id}', [OrderController::class,'updateStatus'])->middleware('checkpermission:update-order-status')->name('order.detail.update');
        
    });

    

});

Route::get('/search-product/{key}',[ApiController::class,'ajaxSearch'])->name('ajaxSearch');

Route::get('/unauthorized', function(){ 
    return view('error.unauthorized');
})->name('unauthorized');
