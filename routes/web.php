<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ReportsController;

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/lotes', [ProductController::class, 'lotes'])->name('products.lotes');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');

Route::get('/customers', [CustomerController::class, 'index'])->name('customers');
Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
Route::get('/customers/{id}/edit', [CustomerController::class, 'edit'])->name('customers.edit');

Route::get('/sales', [SalesController::class, 'index'])->name('sales');
Route::get('/sales/create', [SalesController::class, 'create'])->name('sales.create');
Route::get('/sales/close-shift', [SalesController::class, 'closeShift'])->name('sales.close-shift');
Route::get('/sales/shift-history', [SalesController::class, 'shiftHistory'])->name('sales.shift-history');

Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');
Route::get('/inventory/movements', [InventoryController::class, 'movements'])->name('inventory.movements');
Route::get('/inventory/expired', [InventoryController::class, 'expired'])->name('inventory.expired');
Route::get('/inventory/out-of-stock', [InventoryController::class, 'outOfStock'])->name('inventory.out-of-stock');

Route::get('/reports', [ReportsController::class, 'index'])->name('reports');