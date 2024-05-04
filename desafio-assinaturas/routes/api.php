<?php

use App\Http\Controllers\AssinaturaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CadastroController;
use App\Http\Controllers\FaturaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

## Login ##
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::prefix('cadastros')->group(function () {
        Route::get('/show/{user_id}', [CadastroController::class, 'show']);
        Route::get('/index', [CadastroController::class, 'index']);
        Route::post('/store', [CadastroController::class, 'store']);
        Route::put('/update/{user_id}', [CadastroController::class, 'update']);
        Route::delete('/destroy/{user_id}', [CadastroController::class, 'destroy']);
    });

    Route::prefix('assinaturas')->group(function () {
        Route::get('/show/{assinatura_id}', [AssinaturaController::class, 'show']);
        Route::get('/index', [AssinaturaController::class, 'index']);
        Route::post('/store', [AssinaturaController::class, 'store']);
        Route::put('/update/{assinatura_id}', [AssinaturaController::class, 'update']);
        Route::delete('/destroy/{assinatura_id}', [AssinaturaController::class, 'destroy']);
    });

    Route::prefix('faturas')->group(function () {
        Route::get('/show/{fatura_id}', [FaturaController::class, 'show']);
        Route::get('/index', [FaturaController::class, 'index']);
        Route::post('/store', [FaturaController::class, 'store']);
        Route::put('/update/{fatura_id}', [FaturaController::class, 'update']);
        Route::delete('/destroy/{fatura_id}', [FaturaController::class, 'destroy']);
    });

    ## Logout ##
    Route::post('/logout', [AuthController::class, 'logout']);
});
