<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Carbon\Carbon;

class ControllerVentanillas extends Controller
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
         $listaventanas = DB::table('ventana')->where('id_empresa',$id_DBDT = session('id_DBDEM'))->where('estado_ventana','1')->get();
        //MENU DINAMICO


        
        
        return view('/Administrator/Ventanillas.index', compact('listaventanas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
          if($id_DBDT = session('id_DBDT') == ''){
        Session::flash('message',' No tiene Permisos Debe Iniciar Session');
         return redirect()->route('login.index');
         }else{  
        
       // return view('/Administrator/Ventanillas.create', compact('misiones','ventanas'));
       return view('/Administrator/Ventanillas.create');
           }
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
        $fecha_creacion = date("Y-m-d H:i:s");
        $date = Carbon::now();
        $date = $date->format('Y-m-d H:i:s');

         $request->validate([            
                
                'nombre'              =>    'required',                
                'numero'               =>    'required'
               
                
                
         ]);
         //esta array inserta los datos en la tabla usuario
         DB::table('ventana')->insert([
                
                'nombre'                =>    $request->nombre,                
                'numero'                =>    $request->numero,
                'id_organizacion'       =>    '1',
                'id_empresa'            =>    $id_empresa = session('id_DBDEM'),
                'estado_ventana'        =>    '1',
                'fecha_creacion'        =>    $date
                
         ]);
       
            //si todo funciona correctamente deberia retornar usuario creado correctamente
         Session::flash('message','Ventanillas creada correctamente');
         return redirect()->route('Ventanillas.index');
       // }
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
         $listarVentana = DB::table('ventana')->where('id',$id)->first();

        
                      
        return view('/Administrator/Ventanillas.edit', compact('listarVentana'));
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
        //return $request;
        $fecha_creacion = date("Y-m-d H:i:s");
        $date = Carbon::now();
        $date = $date->format('Y-m-d H:i:s');

         $request->validate([            
                
                'nombre'              =>    'required',                
                'numero'               =>    'required'
               
                
                
         ]);
         //esta array inserta los datos en la tabla usuario
         DB::table('ventana')->where('id', $id)->update([
                
                'nombre'                =>    $request->nombre,                
                'numero'                =>    $request->numero,
                'id_organizacion'       =>    '1',
                'id_empresa'            =>    $id_empresa = session('id_DBDEM'),
                'estado_ventana'        =>    '1',
                'fecha_creacion'        =>    $date
                
         ]);
       
            //si todo funciona correctamente deberia retornar usuario creado correctamente
         Session::flash('message','Ventanillas Actualizada correctamente');
         return redirect()->route('Ventanillas.index');
       // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ventana = DB::table('ventana')->where('id',$id)->first();

        DB::table('ventana')->where('id', $id)->update([                
                
                'estado_ventana'        =>    '0',  
                
         ]);

        Session::flash('message','' .$ventana->nombre. ' Eliminada  correctamente');
         return redirect()->route('Ventanillas.index');
    
    }
}
