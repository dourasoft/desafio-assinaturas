<?php

use App\Http\Controllers\API\CadastroController;
use App\Http\Controllers\API\UserAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/cadastro/{id}', [CadastroController::class, 'show'])->middleware('auth:sanctum');
Route::get('/cadastro', [CadastroController::class, 'index'])->middleware('auth:sanctum');
Route::post('/cadastro', [CadastroController::class, 'store'])->middleware('auth:sanctum');
Route::post('/cadastro/{id}', [CadastroController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/cadastro/{id}', [CadastroController::class, 'delete'])->middleware('auth:sanctum');
Route::post('register', [UserAuthController::class, 'register']);
Route::post('login', [UserAuthController::class, 'login']);
Route::post('logout', [UserAuthController::class, 'logout'])
    ->middleware('auth:sanctum');
