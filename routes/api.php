<?php

use App\Http\Controllers\api\CadastreController;
use App\Http\Controllers\api\InvoiceController;
use App\Http\Controllers\api\SignatureController;
use Illuminate\Http\Request;
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

Route::group(['prefix' => 'cadastre'],function(){
    Route::get('/', [CadastreController::class, 'index']);
    Route::get('/{id}', [CadastreController::class, 'show']);
	Route::post('/', [CadastreController::class, 'store']);
    Route::put('/{id}', [CadastreController::class, 'update']);
	Route::delete('/{id}', [CadastreController::class, 'destroy']);
});

Route::group(['prefix' => 'signature'],function(){
    Route::get('/', [SignatureController::class, 'index']);
    Route::get('/{id}', [SignatureController::class, 'show']);
	Route::post('/', [SignatureController::class, 'store']);
    Route::put('/{id}', [SignatureController::class, 'update']);
	Route::delete('/{id}', [SignatureController::class, 'destroy']);
});

Route::get('/verification_of_signatures', [SignatureController::class, 'verificationOfSignatures']);

Route::group(['prefix' => 'invoice'],function(){
    Route::get('/', [InvoiceController::class, 'index']);
    Route::get('/{id}', [InvoiceController::class, 'show']);
	Route::post('/', [InvoiceController::class, 'store']);
    Route::put('/{id}', [InvoiceController::class, 'update']);
	Route::delete('/{id}', [InvoiceController::class, 'destroy']);
});
