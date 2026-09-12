<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\UserController;
use App\Livewire\Admin\Categories\Index as CategoriesIndex;
use App\Livewire\Admin\Customers\Index as CustomersIndex;
use App\Livewire\Admin\Products\Index as ProductsIndex;
use App\Livewire\Admin\Purchases\Index as PurchasesIndex;
use App\Livewire\Admin\Suppliers\Index as SuppliersIndex;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route(auth()->check() ? 'dashboard' : 'login'))->name('home');

Route::middleware(['auth'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | User Management
    |--------------------------------------------------------------------------
    */

    Route::get('admin/users', [UserController::class, 'index'])
        ->middleware('role:admin')
        ->name('admin.users.index');

    /*
    |--------------------------------------------------------------------------
    | Categories
    |--------------------------------------------------------------------------
    */

    Route::get('admin/categories', CategoriesIndex::class)
        ->middleware('role:admin,stock')
        ->name('admin.categories.index');

    Route::post('admin/categories', [CategoryController::class, 'store'])
        ->middleware('role:admin,stock')
        ->name('admin.categories.store');

    Route::patch('admin/categories/{category}', [CategoryController::class, 'update'])
        ->middleware('role:admin,stock')
        ->name('admin.categories.update');

    /*
    |--------------------------------------------------------------------------
    | Suppliers
    |--------------------------------------------------------------------------
    */

    Route::get('admin/suppliers', SuppliersIndex::class)
        ->middleware('role:admin,stock')
        ->name('admin.suppliers.index');

    Route::post('admin/suppliers', [SupplierController::class, 'store'])
        ->middleware('role:admin,stock')
        ->name('admin.suppliers.store');

    Route::patch('admin/suppliers/{supplier}', [SupplierController::class, 'update'])
        ->middleware('role:admin,stock')
        ->name('admin.suppliers.update');

    /*
    |--------------------------------------------------------------------------
    | Products
    |--------------------------------------------------------------------------
    */

    Route::get('admin/products', ProductsIndex::class)
        ->middleware('role:admin,stock')
        ->name('admin.products.index');

    Route::post('admin/products', [ProductController::class, 'store'])
        ->middleware('role:admin,stock')
        ->name('admin.products.store');

    Route::patch('admin/products/{product}', [ProductController::class, 'update'])
        ->middleware('role:admin,stock')
        ->name('admin.products.update');

    Route::patch('admin/products/{product}/stock', [
        ProductController::class,
        'adjustStock',
    ])
        ->middleware('role:admin,stock')
        ->name('admin.products.stock.adjust');

    /*
    |--------------------------------------------------------------------------
    | Customers
    |--------------------------------------------------------------------------
    */

    Route::get('admin/customers', CustomersIndex::class)
        ->middleware('role:admin,sales')
        ->name('admin.customers.index');

    Route::post('admin/customers', [CustomerController::class, 'store'])
        ->middleware('role:admin,sales')
        ->name('admin.customers.store');

    Route::patch('admin/customers/{customer}', [CustomerController::class, 'update'])
        ->middleware('role:admin,sales')
        ->name('admin.customers.update');

    /*
    |--------------------------------------------------------------------------
    | Purchases
    |--------------------------------------------------------------------------
    */

    Route::get('admin/purchases', PurchasesIndex::class)
        ->middleware('role:admin,stock')
        ->name('admin.purchases.index');

    Route::post('admin/purchases', [PurchaseController::class, 'store'])
        ->middleware('role:admin,stock')
        ->name('admin.purchases.store');

    Route::post('admin/purchases/{purchase}/cancel', [
        PurchaseController::class,
        'cancel',
    ])
        ->middleware('role:admin,stock')
        ->name('admin.purchases.cancel');

    /*
    |--------------------------------------------------------------------------
    | Temporary Security Verification Routes
    |--------------------------------------------------------------------------
    |
    | Remove these before final production submission after the
    | authorization suite has been consolidated.
    |
    */

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
