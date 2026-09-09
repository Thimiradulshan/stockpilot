<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::get('admin/users', [UserController::class, 'index'])
        ->middleware('role:admin')
        ->name('admin.users.index');

    Route::get('admin/categories', [CategoryController::class, 'index'])
        ->middleware('role:admin,stock')
        ->name('admin.categories.index');

    Route::get('admin/suppliers', [SupplierController::class, 'index'])
        ->middleware('role:admin,stock')
        ->name('admin.suppliers.index');

    Route::get('admin/products', [ProductController::class, 'index'])
        ->middleware('role:admin,stock')
        ->name('admin.products.index');

    Route::post('admin/products', [ProductController::class, 'store'])
        ->middleware('role:admin,stock')
        ->name('admin.products.store');

    Route::patch('admin/products/{product}', [ProductController::class, 'update'])
        ->middleware('role:admin,stock')
        ->name('admin.products.update');

    Route::get('admin/customers', [CustomerController::class, 'index'])
        ->middleware('role:admin,sales')
        ->name('admin.customers.index');

    Route::get('security-test/admin', fn () => 'admin-area')
        ->middleware('role:admin')
        ->name('security.test.admin');

    Route::get('security-test/sales', fn () => 'sales-area')
        ->middleware('role:sales')
        ->name('security.test.sales');

    Route::get('security-test/stock', fn () => 'stock-area')
        ->middleware('role:stock')
        ->name('security.test.stock');
});

require __DIR__.'/settings.php';
