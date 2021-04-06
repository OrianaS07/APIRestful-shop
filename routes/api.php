<?php

use App\Http\Controllers\Buyer\BuyerCategoryController;
use App\Http\Controllers\Buyer\BuyerController;
use App\Http\Controllers\Buyer\BuyerProductController;
use App\Http\Controllers\Buyer\BuyerSellerController;
use App\Http\Controllers\Buyer\BuyerTransactionController;
use App\Http\Controllers\Category\CategoryBuyerController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Category\CategoryProductController;
use App\Http\Controllers\Category\CategorySellerController;
use App\Http\Controllers\Category\CategoryTransactionController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Product\ProductBuyerController;
use App\Http\Controllers\Product\ProductBuyerTransactionController;
use App\Http\Controllers\Product\ProductCategoryController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\ProductTransactionController;
use App\Http\Controllers\Seller\SellerBuyerController;
use App\Http\Controllers\Seller\SellerCategoryController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Seller\SellerProductController;
use App\Http\Controllers\Seller\SellerTransactionController;
use App\Http\Controllers\Transaction\TransactionCategoryController;
use App\Http\Controllers\Transaction\TransactionController;
use App\Http\Controllers\Transaction\TransactionSellerController;
use App\Http\Controllers\User\UserController;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

/** USERS */
Route::resource('users', UserController::class)->except('create','edit')->names('users');
Route::get('users/verify/{token}',[UserController::class, 'verify'])->name('verify');
Route::get('users/{user}/resend', [UserController::class, 'resend'])->name('resend');
Route::post('emailRecover', [UserController::class, 'emailRecover'])->name('emailRecover');
Route::post('resetPassword/{user}', [UserController::class, 'resetPassword'])->name('resetPassword');

/**  RUTAS QUE HICE PARA JWT AUTENTICATE*/
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::middleware(['jwt.verify'])->group(function () {
    Route::get('user', [UserController::class, 'getAuthenticatedUser']);
    Route::post('refresh', [UserController::class, 'refresToken']);
    Route::get('logout', [UserController::class, 'logout']);
});

/** CATEGORIES */ 
Route::resource('categories', CategoryController::class)->except('create','edit')->names('categories');
Route::resource('categories.buyers', CategoryBuyerController::class)->only('index')->names('categories.buyers');
Route::resource('categories.sellers', CategorySellerController::class)->only('index')->names('categories.sellers');
Route::resource('categories.products', CategoryProductController::class)->only('index')->names('categories.products');
Route::resource('categories.transactions', CategoryTransactionController::class)->only('index')->names('categories.transactions');

/** PRODUCTS */
Route::resource('products', ProductController::class)->only('index','show')->names('products');
/** 
Route::middleware(['jwt.verify'])->group(function () {
   Route::get('products.user', [ProductController::class, 'getCurrentUserProduct']); 
});*/

Route::resource('products.buyers', ProductBuyerController::class)->only('index')->names('products.buyers');
Route::resource('products.categories', ProductCategoryController::class)->only('index','update','destroy')->names('products.categories');
Route::resource('products.transactions', ProductTransactionController::class)->only('index')->names('products.transactions');
Route::resource('products.buyers.transactions', ProductBuyerTransactionController::class)->only('store')->names('products.buyers.transactions');

/** TRANSACTIONS */
Route::resource('transactions', TransactionController::class)->only('index','show')->names('transactions');
/** 
Route::middleware(['jwt.verify'])->group(function () {
   Route::get('transactions.user', [TransactionController::class, 'getCurrentUserTransactions']); 
});*/

Route::resource('transactions.categories', TransactionCategoryController::class)->only('index')->names('transactiones.categories');
Route::resource('transactions.sellers', TransactionSellerController::class)->only('index')->names('transactiones.sellers');

/** BUYERS */
Route::resource('buyers', BuyerController::class)->only('index','show')->names('buyers');
Route::resource('buyers.sellers', BuyerSellerController::class)->only('index')->names('buyers.sellers');
/** 
Route::middleware(['jwt.verify'])->group(function () {
    Route::get('buyer.sellers', [BuyerSellerController::class, 'getCurrentBuyerSeller']);
});*/
Route::resource('buyers.products', BuyerProductController::class)->only('index')->names('buyers.products');
Route::resource('buyers.categories', BuyerCategoryController::class)->only('index')->names('buyers.categories');
Route::resource('buyers.transactions', BuyerTransactionController::class)->only('index')->names('buyers.transactions');

/** SELLERS */
Route::resource('sellers', SellerController::class)->only('index','show')->names('sellers');
Route::resource('sellers.buyers', SellerBuyerController::class)->only('index')->names('sellers.buyers');
Route::resource('sellers.products', SellerProductController::class)->except('create','show','edit')->names('sellers.products');
Route::resource('sellers.categories', SellerCategoryController::class)->only('index')->names('sellers.categories');
Route::resource('sellers.transactions', SellerTransactionController::class)->only('index')->names('sellers.transactions');




/** REDES SOCIALES */
Route::get('login.google', [LoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [LoginController::class, 'handleGoogleCallback'])->name('login.google.callback');

Route::get('login.facebook', [LoginController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('login/facebook/callback', [LoginController::class, 'handleFacebookCallback'])->name('login.facebook.callback');

Route::get('login.github', [LoginController::class, 'redirectToGithub'])->name('login.github');
Route::get('login/github/callback', [LoginController::class, 'handleGithubCallback'])->name('login.github.callback');
