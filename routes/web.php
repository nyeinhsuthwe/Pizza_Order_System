<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\AdminController;
use App\Models\Product;
use App\Http\Controllers\User\AjaxController;
use App\Http\Controllers\OrderController;


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

});

// login and register

Route::redirect('/', 'loginPage');
Route::get('/loginPage', [AuthController::class, 'loginPage'])->name('authLogin');
Route::get('/registerPage', [AuthController::class, 'registerPage'])->name('authRegister');

//for dashboard
Route::get('/dashboard', [AuthController::class,'dashboard'])->name('dashboard');

//for admin

Route::group(['prefix'=>'category'], function () {
    Route::get('/list', [CategoryController::class, 'list'])->name('categoryList');
    Route::get('/createPage',[CategoryController::class, 'createPage'])->name('categoryCreate');
    Route::post('create',[CategoryController::class,'create'])->name('create');
    Route::get('/delete/{id}',[CategoryController::class,'delete'])->name('delete');
    Route::get('/edit/{id}',[CategoryController::class,'edit'])->name('edit');
    Route::post('/update',[CategoryController::class,'update'])->name('update');

});


Route::group(['prefix'=>'admin'], function(){
    //password
    Route::get('change/password', [AdminController::class, "changePassword"])->name('changePassword');
    Route::post('password/change', [AdminController::class, "change"])->name('change');

    //account
    Route::get('account/info', [AdminController::class, 'accountInfo'])->name('accountInfo');
    Route::get('info/edit',[AdminController::class , 'editInfo'])->name('editInfo');
    Route::post('info/update/{id}',[AdminController::class,'updateInfo'])->name('updateInfo');

    //for admin List
    Route::get('/list',[AdminController::class, 'adminList'])->name('adminList');
    Route::get('/list/delete/{id}',[AdminController::class, 'adminDelete'])->name('adminDelete');
    Route::get('/changeRole/{id}',[AdminController::class, 'changeRole'])->name('changeRole');
    Route::post('/change/{id}',[AdminController::class, 'changeR'])->name('changeR');

    Route::group(['prefix'=>'order'], function () {
        Route::get('/list', [OrderController::class, 'adminOrderList'])->name('adminOrderList');
        Route::post('/sortStatus', [OrderController::class, 'sortStatus'])->name('sortStatus');
        Route::get('/changeStatus', [OrderController::class, 'changeStatus'])->name('changeStatus');
        Route::get('/orderInfo/{orderCode}',[OrderController::class, 'orderInfo'])->name('orderInfo');
    });

    Route::group(['prefix'=>'user'], function () {
        Route::get('/list', [UserController::class, 'userList'])->name('userList');
        Route::get('/user/role', [UserController::class, 'userRole'])->name('userRole');
    });
});


//for products
Route::group(['prefix'=>'products'], function(){
    Route::get('product/list', [ProductController::class, "productList"])->name('productList');
    Route::get('create/pizza', [ProductController::class, 'createPizza'])->name('createPizza');
    Route::post('create',[ProductController::class,'create'])->name('createProduct');
    Route::get('/delete/{id}',[ProductController::class,'delete'])->name('delete');
    Route::get('/editProduct/{id}',[ProductController::class,'editProduct'])->name('editProduct');
    Route::get('/updatePage/{id}',[ProductController::class,'updatePage'])->name('updatePage');
    Route::post('/updateProduct/{id}',[ProductController::class,'updateProduct'])->name('updateProduct');
});

//for user
Route::group(['prefix'=>'user'], function () {
  Route::get('/home' , [UserController::class, 'userHomePage'])->name('userHomePage');
  Route::get('/filter/{id}' , [UserController::class, 'categoryFilter'])->name('categoryFilter');
  Route::get('/history' , [UserController::class, 'orderHistory'])->name('orderHistory');

  Route::group(['prefix'=>'pizza'], function () {
    Route::get('/details/{id}' , [UserController::class, 'details'])->name('details');
  });

  Route::group(['prefix'=>'cart'], function () {
    Route::get('/list' , [UserController::class, 'cartList'])->name('cartList');
  });

  Route::group(['prefix'=>'password'], function () {
    Route::get('/change' , [UserController::class, 'changePassword'])->name('changePassword');
    Route::post('/change' , [UserController::class, 'changePasswordPage'])->name('changePasswordPage');
  });

  Route::group(['prefix'=>'account'], function () {
    Route::get('/accountEdit' , [UserController::class, 'accountEdit'])->name('accountEdit');
    Route::post('/update/{id}' , [UserController::class, 'accountUpdate'])->name('accountUpdate');
  });

  Route::group(['prefix'=>'ajax'], function () {
   Route::get('/pizza/list', [AjaxController::class, 'pizzaListAjax'])->name('pizzaListAjax');
   Route::get('/cart', [AjaxController::class, 'addToCart'])->name('addToCart');
   Route::get('/order', [AjaxController::class, 'orderList'])->name('orderList');
   Route::get('/clear/cart', [AjaxController::class, 'clearCart'])->name('clearCart');
   Route::get('/clear/recentlyCart', [AjaxController::class, 'clearRecentlyCart'])->name('clearRecentlyCart');
  });

});


