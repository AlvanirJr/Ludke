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
    return redirect('/login');
});


Auth::routes();

#Route::post('/login/user', 'CustomLoginController@loginUser');
#Route::get('/logout', 'CustomHomeController@logoutUser');
Route::get('/relatorio/{id}', 'RelatorioPedidosController@RelatorioPedidos')->name('relatorio');
Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// chama a view de produtos
Route::get('/indexProdutos','ProdutoController@indexView')->name('produtos');
Route::post('/buscarProduto','ProdutoController@buscarProduto')->name('buscarProduto');
// Route::post('produtos','ProdutoController@store')->name('produto.store');


// View Categorias
Route::get('/indexCategorias','CategoriaController@indexView')->name('categorias');
Route::post('/buscarCategoria','CategoriaController@buscarCategoria')->name('buscarCategoria');
// View Funcionários
Route::get('/indexFuncionarios','FuncionarioController@indexView')->name('funcionarios');
Route::post('/buscarFuncionario','FuncionarioController@buscarFuncionario')->name('buscarFuncionario');
// Clientes
Route::get('/indexClientes','ClienteController@indexView')->name('clientes');
Route::post('/buscarCliente','ClienteController@buscarCliente')->name('buscarCliente');
// Cargos
Route::get('/indexCargos', 'CargoController@indexView')->name('cargos');
Route::post('/buscarCargo','CargoController@buscarCargo')->name('buscarCargo');

// ROTAS PARA O PEDIDO
Route::get('/pedidos','PedidoController@index')->name('pedidos');
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
Route::any('/pedidos/filtrar','PedidoController@filtrarPedido')->name('pedido.filtrar');

// ROTAS PARA VENDA
Route::get('/vendas', 'VendaController@index')->name('vendas');
Route::get('/vendas/listar/{status?}', 'VendaController@indexListarVendas')->name('listarVendas');
Route::get('/vendas/concluir/{id}', 'VendaController@concluirVenda')->name('vendas.concluirVenda');
Route::post('/vendas/concluir', 'VendaController@concluirVendaPagamento')->name('vendas.concluirVendaPagamento');
Route::post('/vendas/pagamento', 'VendaController@pagamento')->name('vendas.pagamento');





// Antigas rotas da API
Route::resource('/categorias','CategoriaController');
Route::resource('/produtos', 'ProdutoController'); //cria todas as rotas para produto
Route::post('/produtos/{id}','ProdutoController@updateProdWithImage');
Route::resource('/cargos', 'CargoController'); //cria todas as rotas para cargos
Route::resource('/funcionarios', 'FuncionarioController'); //cria todas as rotas para funcionarios
Route::resource('/clientes', 'ClienteController');

// Rotas para testar banco
// use App\Produto;
// use App\Categoria;
// use App\Cliente;
// use App\User;
// use App\Pedido;
// Route::get('/teste',function(){
//     $users = User::with('cliente')->get();
//     $cliente = Cliente::with('user')->get();
//     $produtos = Produto::with('categoria')->find(1);
//     $categoria = Categoria::with('produtos')->get();
//     $pedidos = Pedido::with(['itensPedidos','status'])->get();

//     return json_encode($pedidos);

//     // return $pedidos;
// });
