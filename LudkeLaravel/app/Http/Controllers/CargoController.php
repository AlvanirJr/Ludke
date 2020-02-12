<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cargo;

class CargoController extends Controller
{

    public function indexView()
    {
        return view('cargo');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cargos = Cargo::all();
        return json_encode($cargos);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $cargo = new Cargo();
        $cargo->nome = $request->input('nome');
        $cargo->save();

        return json_encode($cargo);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $cargo = Cargo::find($id);
        if(isset($cargo)){
            return json_encode($cargo);

        }
        else{
            return response('Cargo não encontrada',404);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $cargo = Cargo::find($id);
        if(isset($cargo)){
            $cargo->nome = $request->input('nome');
            $cargo->save();
            return  json_encode($cargo);

        }
        else{
            return response('Cargo não encontrada',404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {        $cargo = Cargo::find($id);
        if(isset($cargo)){
            $cargo->delete();
            return  response("OK",200);

        }
        else{
            return response('Cargo não encontrada',404);
        }
    }
}
