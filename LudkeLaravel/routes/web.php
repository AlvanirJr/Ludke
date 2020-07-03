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
Route::get('/relatorio/{id}', 'RelatorioPedidosController@RelatorioPedidos')->name('pedido.relatorio');
Route::get('/relatorioVendas/{id}', 'RelatorioVendasController@RelatorioVendas')->name('venda.relatorio');
Route::get('/relatorioCliente', 'ClienteController@relatorioCliente')->name('relatorioCliente');
Route::get('/relatorioProdutos', 'RelatorioProdutosController@relatorioProduto')->name('relatorioProdutos');
Route::post('/relatorioGeralPedidos', 'RelatorioPedidosController@RelatorioGeral')->name('relatorioGeralPedidos');
Route::post('/relatorioGeralVendas', 'RelatorioVendasController@RelatorioGeral')->name('relatorioGeralVendas');
// Route::get('/relatorioGeralPedidos', 'RelatorioPedidosController@RelatorioGeral')->name('relatorioGeralPedidos');
Route::get('/getEntregadores','RelatorioPedidosController@getEntregadores');
Route::delete('/removerItem/{id}', 'PedidoController@removerProdutoItem')->name('removerProduto.item');

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
// Rota post para salvar o pedido realizado na tela de pedidos
Route::post('/pedidos/finalizar','PedidoController@finalizarPedido');
Route::delete('/pedidos/excluir/{id}','PedidoController@destroy');// Deletar um pedido
// Rota GET que redireciona para tela de pesagem do pedido
Route::get('/pedidos/pesar/{id}','PedidoController@pesarPedido')->name('pedido.pesarPedido');
// rota POST que salva a pesagem dos pedidos
Route::post('/pedidos/pesar','PedidoController@concluirPedidoPesoFinal')->name('pedido.concluirPedidoPesoFinal');// Concluir um pedido aberto
// Rota get que redireciona para tela de concluir pedido
Route::get('/pedidos/concluir/{id}', 'PedidoController@concluirPedido')->name('pedido.concluirPedido');
// Rota POST que salva os descontos aplicados nos itens da view concluirPedido.
Route::post('/pedidos/concluir', 'PedidoController@concluirPedidoComDescontoNosItens')->name('pedido.concluirPedidoComDescontoNosItens') ;

//Rota GET que redireciona para tela de registrar entrega do pedido
Route::get('/pedidos/registrarEntrega/{id}','PedidoController@indexRegistrarEntregaPedido')->name('pedido.indexRegistrarEntrega');
//Rota POST que salva a entrega do pedido
Route::post('/pedidos/registrarEntrega','PedidoController@registrarEntregaPedido')->name('pedido.registrarEntregaPedido');

// Pagamento Pedido
Route::get('/pedidos/pagamento/{id}','PedidoController@indexPagamento')->name('pedido.indexPagamento');
Route::post('/pedidos/pagamento','PedidoController@pagamento')->name('pedido.pagamento');

Route::get('/pedidos/listar/{id?}','PedidoController@indexListarPedidos')->name("listarPedidos");
Route::get('/getPedidos','PedidoController@getPedidos');
Route::get('/pedidos/edit/{id}','PedidoController@edit')->name('pedido.editar'); //Editar Pedido
Route::put('/pedidos/update/{id}','PedidoController@update');
Route::any('/pedidos/filtrar','PedidoController@filtrarPedido')->name('pedido.filtrar');

// ROTAS PARA VENDA
// tela de realizar venda
Route::get('/vendas', 'VendaController@index')->name('vendas');
// tela de Listar vendas
Route::get('/vendas/listar/{status?}', 'VendaController@indexListarVendas')->name('listarVendas');
// Rota post para salvar venda na tela de vendas
Route::post('/vendas/finalizar','VendaController@finalizarVenda');

// Concluir Venda
// Rota get que redireciona para tela de concluir pedido
Route::get('/vendas/concluir/{id}', 'VendaController@concluirVenda')->name('concluirVenda');
// Rota POST que salva os descontos aplicados nos itens da view concluirPedido.
Route::post('/vendas/concluir', 'VendaController@concluirVendaComDescontoNosItens')->name('concluirVendaComDescontoNosItens') ;


// Pagamento Venda
Route::get('/vendas/pagamento/{id}','VendaController@indexPagamento')->name('venda.indexPagamento');
Route::post('/vendas/pagamento','VendaController@pagamento')->name('venda.pagamento');


//Rota GET que redireciona para tela de registrar entrega da venda
Route::get('/vendas/registrarEntrega/{id}','VendaController@indexRegistrarEntregaPedido')->name('venda.indexRegistrarEntrega');
//Rota POST que salva a entrega da venda
Route::post('/vendas/registrarEntrega','VendaController@registrarEntregaPedido')->name('venda.registrarEntregaPedido');

// Route::get('/vendas/concluir/{id}', 'VendaController@concluirVenda')->name('vendas.concluirVenda');
// Route::post('/vendas/concluir', 'VendaController@concluirVendaPagamento')->name('vendas.concluirVendaPagamento');
// Route::post('/vendas/pagamento', 'VendaController@pagamento')->name('vendas.pagamento');
Route::any('/vendas/filtrar','VendaController@filtrarVenda')->name('vendas.filtrar');





// Antigas rotas da API
Route::resource('/categorias','CategoriaController');
Route::resource('/produtos', 'ProdutoController'); //cria todas as rotas para produto
Route::post('/produtos/{id}','ProdutoController@updateProdWithImage');
Route::resource('/cargos', 'CargoController'); //cria todas as rotas para cargos
Route::resource('/funcionarios', 'FuncionarioController'); //cria todas as rotas para funcionarios
Route::resource('/clientes', 'ClienteController');



// ROTAS CONTAS A RECEBER
Route::get('/contas/receber/{idPedido?}','ContasReceber@index')->name('contas.receber');
Route::get('/contas/visualizar/{id}','ContasReceber@show')->name('contas.visualizar');
Route::post('/contas/registrarPagamento','ContasReceber@store')->name('contas.registrarPagamento');
Route::get('/contas/visualizar/pedido/{id}','PedidoController@show')->name('contas.visualizarPedido');
Route::get('/contas/visualizar/venda/{id}','VendaController@show')->name('contas.visualizarVenda');
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
