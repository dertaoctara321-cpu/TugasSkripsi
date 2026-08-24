<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user && ($user->isDapur() || $user->isKasir())) {
        return redirect()->route('orders.index');
    }
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin & Staff Routes
    Route::prefix('admin')->middleware('nocache')->group(function () {
        
        // 1. Dashboard & Reports (Admin & Owner)
        Route::middleware('role:admin,owner')->group(function () {
            Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
            Route::get('/reports', [App\Http\Controllers\AdminController::class, 'reports'])->name('admin.reports');
        });

        // 2. Orders View (Admin, Dapur, Kasir, Owner)
        Route::middleware('role:admin,dapur,kasir,owner')->group(function () {
            Route::get('orders', [App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
            Route::get('orders/{order}', [App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
        });

        // 3. Update Order Status (Admin & Dapur)
        Route::middleware('role:admin,dapur')->group(function () {
            Route::put('orders/{order}/status', [App\Http\Controllers\OrderController::class, 'updateStatus'])->name('orders.updateStatus');
        });

        // 4. Payment Verification, Table Monitoring & Clear Table (Admin & Kasir)
        Route::middleware('role:admin,kasir')->group(function () {
            Route::put('orders/{order}/payment', [App\Http\Controllers\OrderController::class, 'verifyPayment'])->name('orders.verifyPayment');
            Route::get('tables', [App\Http\Controllers\TableController::class, 'index'])->name('tables.index');
            Route::post('tables/{table}/clear', [App\Http\Controllers\TableController::class, 'clearTable'])->name('tables.clear');
        });

        // 5. Delete Order (Admin only)
        Route::middleware('role:admin')->group(function () {
            Route::delete('orders/{order}', [App\Http\Controllers\OrderController::class, 'destroy'])->name('orders.destroy');
        });

        // 6. Master Data & Staff Management (Admin only)
        Route::middleware('role:admin')->group(function () {
            Route::patch('menus/{menu}/toggle-availability', [App\Http\Controllers\MenuController::class, 'toggleAvailability'])->name('menus.toggleAvailability');
            Route::resource('menus', App\Http\Controllers\MenuController::class);
            Route::resource('tables', App\Http\Controllers\TableController::class)->except(['index']);
            Route::resource('payment-methods', App\Http\Controllers\PaymentMethodController::class);
            Route::resource('users', App\Http\Controllers\UserController::class)->except(['create', 'show', 'edit']);
        });
    });
});

require __DIR__.'/auth.php';

// Customer Routes
Route::get('/order/{uuid}', [App\Http\Controllers\CustomerController::class, 'index'])->name('order.index');
Route::post('/order/{uuid}/cart', [App\Http\Controllers\CustomerController::class, 'addToCart'])->name('order.addToCart');
Route::get('/order/{uuid}/checkout', [App\Http\Controllers\CustomerController::class, 'checkout'])->name('order.checkout');
Route::post('/order/{uuid}/place', [App\Http\Controllers\CustomerController::class, 'placeOrder'])->name('order.placeOrder');
Route::get('/order/{uuid}/status/{order}', [App\Http\Controllers\CustomerController::class, 'status'])->name('order.status');
Route::get('/order/{uuid}/status/{order}/check', [App\Http\Controllers\CustomerController::class, 'checkStatus'])->name('order.checkStatus');
Route::post('/order/{uuid}/rate/{order}', [App\Http\Controllers\CustomerController::class, 'rateOrder'])->name('order.rate');
Route::get('/order/{uuid}/payment-info', [App\Http\Controllers\CustomerController::class, 'paymentInfo'])->name('order.paymentInfo');

// Live Cart Routes
Route::post('/order/{uuid}/cart/update', [App\Http\Controllers\CustomerController::class, 'updateCartItem'])->name('order.updateCartItem');
Route::post('/order/{uuid}/cart/clear', [App\Http\Controllers\CustomerController::class, 'clearCart'])->name('order.clearCart');

