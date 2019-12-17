<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// View Produtos
Route::get('produtos','ProdutoController@index')->name('produtos');
Route::post('produtos','ProdutoController@store')->name('produto.store');


// View Categorias
Route::get('/categorias','CategoriaController@index')->name('categorias');
Route::get('/categorias','CategoriaController@create')->name('categorias');
Route::post('/categorias','CategoriaController@adicionar')->name('categorias');
