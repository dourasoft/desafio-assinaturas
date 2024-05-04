<?php

use App\Http\Controllers\API\CadastroController;
use App\Http\Controllers\API\AssinaturaController;
use App\Http\Controllers\API\FaturaController;
use App\Http\Controllers\API\UserAuthController;
use Illuminate\Support\Facades\Route;

// Rotas de cadastro
Route::get('/cadastro/{id}', [CadastroController::class, 'show'])->middleware('auth:sanctum');
Route::get('/cadastro', [CadastroController::class, 'index'])->middleware('auth:sanctum');
Route::post('/cadastro', [CadastroController::class, 'store'])->middleware('auth:sanctum');
Route::post('/cadastro/{id}', [CadastroController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/cadastro/{id}', [CadastroController::class, 'destroy'])->middleware('auth:sanctum');

// Rotas de autenticação
Route::post('register', [UserAuthController::class, 'register']);
Route::post('login', [UserAuthController::class, 'login']);
Route::post('logout', [UserAuthController::class, 'logout'])->middleware('auth:sanctum');

// Rotas de Assinatura
Route::get('/assinatura', [AssinaturaController::class, 'index'])->middleware('auth:sanctum');
Route::post('/assinatura', [AssinaturaController::class, 'store'])->middleware('auth:sanctum');
Route::delete('/assinatura/{id}', [AssinaturaController::class, 'destroy'])->middleware('auth:sanctum');
Route::get('/assinatura/{id}', [AssinaturaController::class, 'show'])->middleware('auth:sanctum');
Route::post('/assinatura/{id}', [AssinaturaController::class, 'update'])->middleware('auth:sanctum');

// Rotas de Fatura
Route::get('/fatura', [FaturaController::class, 'index'])->middleware('auth:sanctum');
Route::get('/fatura/{id}', [FaturaController::class, 'show'])->middleware('auth:sanctum');
Route::post('/fatura', [FaturaController::class, 'store'])->middleware('auth:sanctum');
Route::post('/fatura/{id}', [FaturaController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/fatura/{id}', [FaturaController::class, 'destroy'])->middleware('auth:sanctum');
