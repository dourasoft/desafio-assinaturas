<?php

use App\Http\Controllers\CadastroController;
use Illuminate\Support\Facades\Route;

Route::prefix('cadastro')->group(function () {
    Route::get('/', [CadastroController::class, 'getAll']);
    Route::get('/id', [CadastroController::class, 'getById']);
    Route::post('/', [CadastroController::class, 'store']);
    Route::put('/edit', [CadastroController::class, 'edit']);
    Route::delete('/delete', [CadastroController::class, 'delete']);
});
