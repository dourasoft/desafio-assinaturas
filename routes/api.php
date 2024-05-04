<?php

use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('registers')->group(function () {
    Route::get('/', [RegisterController::class, 'index'])->name('apiregisters.index');
    Route::post('/', [RegisterController::class, 'store'])->name('apiregisters.store');
    Route::get('/{register}', [RegisterController::class, 'show'])->name('apiregisters.show');
    Route::put('/{register}', [RegisterController::class, 'update'])->name('apiregisters.edit');
    Route::delete('/{register}', [RegisterController::class, 'destroy'])->name('apiregisters.destroy');
});
