<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

class ControllerTransportista extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return view('usuarios.index', compact('listausuarios'));

        return view('Transportista.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        
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
        $Patente = $id;
        $folio=$request->folio;
        $uniqueid=$request->uniqueid;
        $nombre_mision=$request->nombre_mision;
        if ($Patente == '') {
            Session::flash('message','Ingrese una Patente');
         return redirect()->route('Transportista.index');
        }


        $fecha_Ingreso = date("d/m/Y H:i");
        
       $ubicacion = DB::table('ubicacion_camion')->where('uniqueid',$request->uniqueid)->get();
       $valida = DB::table('ubicacion_camion')->where('uniqueid',$request->uniqueid)->first();
       // return $ubicacion;
       if($valida == '') {
            Session::flash('message','Camion no ha ingresado al CLC');
         return redirect()->route('Transportista.index');
        }else{
            return view('Transportista.update', compact('ubicacion','Patente','fecha_Ingreso','folio','nombre_mision','uniqueid'));
        } 
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
