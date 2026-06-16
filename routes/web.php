<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Routes
    Route::prefix('admin')->middleware('nocache')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/reports', [App\Http\Controllers\AdminController::class, 'reports'])->name('admin.reports');
        
        // PDF Import routes — MUST be before resource to avoid conflict with {menu} param
        Route::post('menus/import-pdf/process', [App\Http\Controllers\MenuController::class, 'importPdfProcess'])->name('menus.importPdfProcess');
        Route::get('menus/import-pdf/review', [App\Http\Controllers\MenuController::class, 'importPdfReview'])->name('menus.importPdfReview');
        Route::post('menus/import-pdf/save', [App\Http\Controllers\MenuController::class, 'importPdfSave'])->name('menus.importPdfSave');
        
        // Bulk Image Upload Route
        Route::post('menus/bulk-upload-images', [App\Http\Controllers\MenuController::class, 'bulkImageUpload'])->name('menus.bulkImageUpload');

        Route::resource('menus', App\Http\Controllers\MenuController::class);
        Route::resource('tables', App\Http\Controllers\TableController::class);
        Route::post('tables/{table}/clear', [App\Http\Controllers\TableController::class, 'clearTable'])->name('tables.clear');
        Route::resource('payment-methods', App\Http\Controllers\PaymentMethodController::class);
        
        Route::get('orders', [App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
        Route::put('orders/{order}/status', [App\Http\Controllers\OrderController::class, 'updateStatus'])->name('orders.updateStatus');
        Route::put('orders/{order}/payment', [App\Http\Controllers\OrderController::class, 'verifyPayment'])->name('orders.verifyPayment');
        Route::delete('orders/{order}', [App\Http\Controllers\OrderController::class, 'destroy'])->name('orders.destroy');
    });
});

require __DIR__.'/auth.php';

// Customer Routes
Route::get('/order/{uuid}', [App\Http\Controllers\CustomerController::class, 'index'])->name('order.index');
Route::post('/order/{uuid}/cart', [App\Http\Controllers\CustomerController::class, 'addToCart'])->name('order.addToCart');
Route::get('/order/{uuid}/checkout', [App\Http\Controllers\CustomerController::class, 'checkout'])->name('order.checkout');
Route::post('/order/{uuid}/place', [App\Http\Controllers\CustomerController::class, 'placeOrder'])->name('order.placeOrder');
Route::get('/order/{uuid}/status/{order}', [App\Http\Controllers\CustomerController::class, 'status'])->name('order.status');
Route::get('/order/{uuid}/payment-info', [App\Http\Controllers\CustomerController::class, 'paymentInfo'])->name('order.paymentInfo');

// Live Cart Routes
Route::post('/order/{uuid}/cart/update', [App\Http\Controllers\CustomerController::class, 'updateCartItem'])->name('order.updateCartItem');
Route::post('/order/{uuid}/cart/clear', [App\Http\Controllers\CustomerController::class, 'clearCart'])->name('order.clearCart');
