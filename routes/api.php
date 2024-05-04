<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CadastroController;
use App\Http\Controllers\AssinaturaController;
use App\Http\Controllers\FaturaController;

/**
 * Deve possuir um CRUD Listagem/Inclusão/Edição/Exclusão de Cadastros
 * Deve possuir um CRUD Listagem/Inclusão/Edição/Exclusão de Assinaturas
 * Deve possuir um CRUD Listagem/Inclusão/Edição/Exclusão de Faturas
 * Deve possuir uma Task que verifica uma vez ao dia todas as assinaturas que vencem daqui a 10 dias e converta elas em faturas.
 * A Task não pode converter faturas já convertidas hoje.
 *
 * Criar as Migrations
 * Criar os Seeds
 */


/**
 * Cadastro group
 */
Route::get('/cadastro/getall', [CadastroController::class, 'getAllCadastros']);

Route::get('/cadastro/get/{id?}', [CadastroController::class, 'getCadastro']);

Route::post('/cadastro/insert', [CadastroController::class, 'insertCadastro']);

Route::put('/cadastro/update/{id?}', [CadastroController::class, 'updateCadastro']);

Route::delete('/cadastro/delete/{id?}', [CadastroController::class, 'deleteCadastro']);

/**
 * Assinatura group
 */
Route::get('/assinatura/getall', [AssinaturaController::class, 'getAllAssinaturas']);

Route::get('/assinatura/get/{id?}', [AssinaturaController::class, 'getAssinatura']);

Route::post('/assinatura/insert', [AssinaturaController::class, 'insertAssinaturas']);

Route::put('/assinatura/update/{id?}', [AssinaturaController::class, 'updateAssinatura']);

Route::delete('/assinatura/delete/{id?}', [AssinaturaController::class, 'deleteAssinatura']);

/**
 * Fatura group
 */
Route::get('/fatura/getall', [FaturaController::class, 'getAllFaturas']);

Route::get('/fatura/get/{id?}', [FaturaController::class, 'getFatura']);

Route::post('/fatura/insert', [FaturaController::class, 'insertFatura']);

Route::put('/fatura/update/{id?}', [FaturaController::class, 'updateFatura']);

Route::delete('/fatura/delete/{id?}', [FaturaController::class, 'deleteFatura']);
