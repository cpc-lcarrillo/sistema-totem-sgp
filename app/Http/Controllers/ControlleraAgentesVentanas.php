<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

class ControlleraAgentesVentanas extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if($id_DBDT = session('id_DBDT') == ''){
            Session::flash('message',' No tiene Permisos Debe Iniciar Session');
             return redirect()->route('login.index');
             }
        
        $AgentesVentana = DB::table('agente_ventana')
            ->join('agente', 'agente_ventana.id_agente', '=', 'agente.id')
            ->join('ventana', 'agente_ventana.id_ventana', '=', 'ventana.id')
            ->select('agente_ventana.id', 'agente.nombre as nombre_agente', 'ventana.nombre as nombre_ventanilla')            
            ->get();

            //  return $AgentesVentana;
            return view('/Administrator/AgentesVentana.index', compact('AgentesVentana'));

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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $AgentesVentana = DB::table('agente_ventana')
        ->join('agente', 'agente_ventana.id_agente', '=', 'agente.id')
        ->join('ventana', 'agente_ventana.id_ventana', '=', 'ventana.id')
        ->select('agente_ventana.id', 'agente.nombre as nombre_agente', 'ventana.nombre as nombre_ventanilla')            
        ->where('agente_ventana.id',$id)
        ->first();
        // return $AgentesVentana;


        DB::table('agente_ventana')->where('agente_ventana.id', $id)->delete();

    Session::flash('message','Agente ' .$AgentesVentana->nombre_agente. ' Quitado  correctamente');
     return redirect()->route('AgentesVentana.index');
    }
}
