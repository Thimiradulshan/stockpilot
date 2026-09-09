<?php

use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::get('admin/users', [UserController::class, 'index'])
        ->middleware('role:admin')
        ->name('admin.users.index');

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
