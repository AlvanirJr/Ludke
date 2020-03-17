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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// chama a view de produtos
Route::get('/produtos','ProdutoController@indexView')->name('produtos');
// Route::post('produtos','ProdutoController@store')->name('produto.store');


// View Categorias
Route::get('/indexCategorias','CategoriaController@indexView')->name('categorias');

// View Funcionários
Route::get('/funcionarios','FuncionarioController@indexView')->name('funcionarios');

Route::get('/clientes','ClienteController@indexView')->name('clientes');

Route::get('/cargos', 'CargoController@indexView')->name('cargos');

Route::get('/pedidos','PedidoController@index')->name('pedidos');

// ROTAS PARA O PEDIDO
Route::post('/pedidos/getCliente','PedidoController@getCliente');
Route::post('/pedidos/buscaCliente/{id}','PedidoController@buscaCliente');
Route::post('/pedidos/getProdutos','PedidoController@getProdutos');
Route::post('/pedidos/finalizar','PedidoController@finalizarPedido');
Route::delete('/pedidos/excluir/{id}','PedidoController@destroy');// Deletar um pedido
Route::get('/pedidos/concluir/{id}','PedidoController@concluirPedido');// Concluir um pedido aberto
Route::post('/pedidos/concluir','PedidoController@concluirPedidoPesoFinal')->name('concluirPedidoPesoFinal');// Concluir um pedido aberto

Route::get('/pedidos/listar','PedidoController@indexListarPedidos')->name("listarPedidos");
Route::get('/getPedidos','PedidoController@getPedidos');
Route::get('/pedidos/edit/{id}','PedidoController@edit')->name('pedido.editar'); //Editar Pedido
Route::put('/pedidos/update/{id}','PedidoController@update');

Route::resource('/categorias','CategoriaController');

// Rotas para testar banco
use App\Produto;
use App\Categoria;
use App\Cliente;
use App\User;
use App\Pedido;
Route::get('/teste',function(){
    $users = User::with('cliente')->get();
    $cliente = Cliente::with('user')->get();
    $produtos = Produto::with('categoria')->find(1);
    $categoria = Categoria::with('produtos')->get();
    $pedidos = Pedido::with(['itensPedidos'])->get();

    return json_encode($users[2]->cliente);

    // return $pedidos;
});