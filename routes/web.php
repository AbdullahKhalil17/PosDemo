<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Management\StoresController;
use App\Http\Controllers\Management\ProductsController;
use App\Http\Controllers\Management\PurchaseInvoiceController;
use App\Http\Controllers\Management\SalesInvoiceController;
use App\Http\Controllers\Management\ShiftsController;

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

Route::middleware('guest:web')->group(function () {
  // Route::get('login', AuthController::class, 'index');
      Route::get('login', [AuthController::class, 'index'])->name('login');
      Route::post('login', [AuthController::class, 'login'])->name('loginNow');
});


Route::middleware('auth:web')->group(function () {
  Route::get('/', function () {
      return view('welcome');
  })->name('dashboard');

  Route::post('logout', [AuthController::class, 'logout'])->name('logout');

  Route::prefix('stores')->name('stores.')->group(function () {
    Route::get('/', [StoresController::class, 'index'])->name('index');
    Route::get('create', [StoresController::class, 'create'])->name('create');
    Route::post('store', [StoresController::class, 'store'])->name('store');
    Route::get('edit/{id}', [StoresController::class, 'edit'])->name('view');
    Route::put('update/{id}', [StoresController::class, 'update'])->name('update');
    Route::delete('destroy/{id}', [StoresController::class, 'destroy'])->name('destroy');
  });

  // Product Management Routes
  Route::prefix('product')->name('product.')->group(function () {
      Route::get('/', [ProductsController::class, 'index'])->name('index');
      Route::get('create', [ProductsController::class, 'create'])->name('create');
      Route::post('store', [ProductsController::class, 'store'])->name('store');
      Route::get('edit/{id}', [ProductsController::class, 'edit'])->name('edit');
      Route::put('update/{id}', [ProductsController::class, 'update'])->name('update');
      Route::delete('delete/{id}', [ProductsController::class, 'destroy'])->name('destroy');
      Route::get('search/product', [PurchaseInvoiceController::class, 'searchProduct'])->name('searchProduct');
  });



  Route::prefix('purchase')->name('purchaseInvoice.')->group(function () {
      Route::get('/', [PurchaseInvoiceController::class, 'index'])->name('index');
      Route::post('store', [PurchaseInvoiceController::class, 'store'])->name('store');
      Route::get('report', [PurchaseInvoiceController::class, 'reportInvoice'])->name('report');
  });

  Route::prefix('sales')->name('salesInvoice.')->group(function () {
    Route::get('/', [SalesInvoiceController::class, 'index'])->name('index');
    Route::get('/search', [SalesInvoiceController::class, 'searchProduct'])->name('searchProduct');
    Route::post('store', [SalesInvoiceController::class, 'store'])->name('store');
    Route::get('report', [SalesInvoiceController::class, 'report'])->name('report');
    Route::get('latest-price/{id}', [SalesInvoiceController::class, 'latestPrice'])->name('latestPrice');
  });



    Route::prefix('shifts')->name('shifts.')->group(function () {
      Route::get('/', [ShiftsController::class, 'index'])->name('index');
      Route::post('close', [ShiftsController::class, 'close'])->name('close');
    });

});