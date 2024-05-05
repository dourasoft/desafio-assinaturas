<?php

use App\Http\Controllers\AssinaturasController;
use App\Http\Controllers\CadastroController;
use App\Http\Controllers\FaturasController;
use Illuminate\Support\Facades\Route;

Route::prefix('cadastro')->group(function () {
    Route::get('/', [CadastroController::class, 'index']);
    Route::post('/', [CadastroController::class, 'store']);
    Route::get('/id', [CadastroController::class, 'show']);
    Route::put('/update', [CadastroController::class, 'update']);
    Route::delete('/destroy', [CadastroController::class, 'destroy']);
});

Route::prefix('assinatura')->group(function () {
    Route::get('/', [AssinaturasController::class, 'index']);
    Route::post('/', [AssinaturasController::class, 'store']);
    Route::get('/id', [AssinaturasController::class, 'show']);
    Route::put('/update', [AssinaturasController::class, 'update']);
    Route::delete('/destroy', [AssinaturasController::class, 'destroy']);
});

Route::prefix('fatura')->group(function () {
    Route::get('/', [FaturasController::class, 'index']);
    Route::post('/', [FaturasController::class, 'store']);
    Route::get('/id', [FaturasController::class, 'show']);
    Route::put('/update', [FaturasController::class, 'update']);
    Route::delete('/destroy', [FaturasController::class, 'destroy']);
});
