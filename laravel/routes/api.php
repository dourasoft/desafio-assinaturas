<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CadastroController;

Route::get('/cadastro/{id}', [CadastroController::class, 'show'])->middleware('auth:sanctum');
