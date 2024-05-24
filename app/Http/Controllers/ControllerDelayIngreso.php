<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
class ControllerDelayIngreso extends Controller
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
            // paginacion
            $ListaDelays = DB::table('DelayIngreso')->get();
            //MENU DINAMICO
            
            return view('/Administrator/DelayIngreso.index', compact('ListaDelays'));
    
            //return view('/Administrator/Users.index');
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
        $DelayIngreso = DB::table('DelayIngreso')->where('id',$id)->first();

        
                      
        return view('/Administrator/DelayIngreso.edit', compact('DelayIngreso'));
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
        $request->validate([            
                
            'Delay_Inicio'       =>    'required',                
            'Delay_Fin'      =>    'required',
            
            
     ]);
     //esta array inserta los datos en la tabla usuario
     DB::table('DelayIngreso')->where('id', $id)->update([
            
            
            'Delay_Inicio'               =>    $request->Delay_Inicio,
            'Delay_Fin'              =>    $request->Delay_Fin
           
     ]);
   
        //si todo funciona correctamente deberia retornar usuario creado correctamente
     Session::flash('message','Minutos Actualizado correctamente');
     return redirect()->route('DelayIngreso.index');
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
