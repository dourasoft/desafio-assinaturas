<?php

use App\Http\Controllers\CadastroController;
use Illuminate\Support\Facades\Route;

Route::prefix('cadastro')->group(function () {
    Route::get('/', [CadastroController::class, 'getAll']);
    Route::get('/id/{id}', [CadastroController::class, 'getById']);
    Route::get('/{codigo}', [CadastroController::class, 'getByCodigo']);
    Route::post('/', [CadastroController::class, 'store']);
});

