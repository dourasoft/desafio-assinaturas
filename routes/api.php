<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::prefix('v1')->group(function () {
    Route::prefix('registers')->group(function () {
        Route::get('/', [RegisterController::class, 'index'])->name('api.registers.index');
        Route::get('/{register}', [RegisterController::class, 'show'])->name('api.registers.show');
        Route::post('/', [RegisterController::class, 'store'])->name('api.registers.store');
        Route::put('/{register}', [RegisterController::class, 'update'])->name('api.registers.edit');
        Route::delete('/{register}', [RegisterController::class, 'destroy'])->name('api.registers.destroy');
        Route::prefix('{register}')->group(function () {
            Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('api.subscriptions.index');
            Route::get('/subscriptions/{subscription}', [SubscriptionController::class, 'show'])->name('api.subscriptions.show');
            Route::post('/subscriptions', [SubscriptionController::class, 'store'])->name('api.subscriptions.store');
            Route::put('/subscriptions/{subscription}', [SubscriptionController::class, 'update'])->name('api.subscriptions.edit');
            Route::delete('/subscriptions/{subscription}', [SubscriptionController::class, 'destroy'])->name('api.subscriptions.destroy');
            Route::prefix('subscriptions/{subscription}')->group(function () {
                Route::get('/invoices', [InvoiceController::class, 'index'])->name('api.invoices.index');
                Route::post('/invoices', [InvoiceController::class, 'store'])->name('api.invoices.store');
                Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('api.invoices.show');
                Route::put('/invoices/{invoice}', [InvoiceController::class, 'update'])->name('api.invoices.edit');
                Route::delete('/invoices/{invoice}', [InvoiceController::class, 'destroy'])->name('api.invoices.destroy');
            });
        });
    });
});
