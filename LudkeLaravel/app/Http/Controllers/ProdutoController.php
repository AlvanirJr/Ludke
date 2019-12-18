<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produto;

class ProdutoController extends Controller
{
    // Retorna a view dos produtos
    public function indexView()
    {
        return view('produto');
    }

    //usado pela api para retornar os produtos
    public function index()
    {
        $produtos = Produto::all();
        return $produtos->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//
    }


    // Recebe o request do ajax
    public function store(Request $request)
    {
        // salva produtos no banco
        $prod = new Produto();
        $prod->nome = $request->input('nome');
        $prod->validade = $request->input('validade');
        $prod->quantidade = $request->input('quantidade');
        $prod->preco = $request->input('preco');
        $prod->descricao = $request->input('descricao');
        $prod->categoria_id = $request->input('categoria_id');
        
      
        $prod->save();
        // retorna o objeto para exibir na tabela
        return json_encode($prod);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
//
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//
    }
}
