<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Management\UnitsController;
use App\Http\Controllers\Management\StoresController;
use App\Http\Controllers\Management\ProductsController;
use App\Http\Controllers\Management\PurchaseInvoiceController;

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

});