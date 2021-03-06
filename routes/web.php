<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ClientsController;

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

Route::get('/', [ProductsController::class, 'index'])->name('welcome');
Route::get('/orders/create/{id_product}', [OrdersController::class, 'create'])->name('orders.create');
Route::post('clients', [ClientsController::class, 'store'])->name('clients.store');
Route::get('/orders/response/{code}', [OrdersController::class, 'responsePlacetoPay'])->name('orders.response');
Route::get('/orders/retrypayment/{ref}', [OrdersController::class, 'retryPayment'])->name('orders.retrypayment');
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


