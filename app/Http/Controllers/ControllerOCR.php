<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection as Collection;
use DB;
use Session;
class ControllerOCR extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $EstadoOCR = DB::table('AdminOCR')
             ->select('estado_actividad')
             ->get(); 
        //return $EstadoOCR;
        return view('/Administrator/Ocr.index', compact('EstadoOCR'));
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
        //return $request;
       

        $request->validate([            
                
            'ActivoOCR'                 =>    'required'                
            
            
     ]);
     //esta array inserta los datos en la tabla usuario
     DB::table('AdminOCR')->update([
            
            'estado_actividad'   =>    $request->ActivoOCR              
            
     ]);
   
        //si todo funciona correctamente deberia retornar usuario creado correctamente
     Session::flash('message',' Actualizado correctamente');
    //  return redirect()->route('Agentes.index');
    return redirect()->back();


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
        //
    }
}
