<?php

use App\Http\Controllers\Auth\AuthController;
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
});