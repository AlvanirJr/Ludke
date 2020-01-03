<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Rota chamada pelo ajax para pegar categorias
// Route::get('/categorias','CategoriaController@indexJson');//para retornar o json com as categorias

Route::resource('/categorias','CategoriaController');

// cria todas as rotas de produto. verificar com " php artisan route:list "
Route::resource('/produtos', 'ProdutoController'); //cria todas as rotas para produto
