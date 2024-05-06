<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{UserController, AssinaturasController, FaturaController};


Route::apiresources([
    'users' => UserController::class,
    'assinaturas' => AssinaturasController::class,
    'faturas' => FaturaController::class,
]);