<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CadastroController;

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

Route::get('/cadastro/getall', [CadastroController::class,'getAllcadastros']);

Route::get('/cadastro/get/{id?}', [CadastroController::class,'getcadastro']);

Route::post('/cadastro/insert', [CadastroController::class, 'insertcadastros']);

Route::put('/cadastro/update/{id?}', [CadastroController::class,'updatecadastro']);

Route::delete('/cadastro/delete/{id?}', [CadastroController::class,'deletecadastro']);
