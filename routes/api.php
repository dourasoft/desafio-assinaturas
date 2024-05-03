<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::get('/user/getall', [UserController::class,'getAllUsers']);

Route::get('/user/get/{id?}', [UserController::class,'getUser']);

Route::post('/user/insert', [UserController::class, 'insertUsers']);

Route::put('/user/update/{id?}', [UserController::class,'updateUser']);

Route::delete('/user/delete/{id?}', [UserController::class,'deleteUser']);
