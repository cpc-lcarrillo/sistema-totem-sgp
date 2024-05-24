<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

class ControllerAgentes extends Controller
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
        $listaAgentes = DB::table('agente')->where('id_empresa',$id_DBDT = session('id_DBDEM'))->where('estado_agente','1')->get();
        //MENU DINAMICO
        
        return view('/Administrator/Agentes.index', compact('listaAgentes'));
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
        
       $listaAgentes = DB::table('agente')->where('id',$id_DBDT = session('id_DBDEM'))->get();
       



        

       return view('/Administrator/Agentes.create', compact('listaAgentes'));
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
        // return $request;
         $fecha_creacion = date("Y-m-d H:i:s");

         $request->validate([            
                
                'nombre'                 =>    'required',                
                'usuario'                =>    'required',
                'clave'               =>    'required'
                
                
         ]);
         //esta array inserta los datos en la tabla usuario
         DB::table('agente')->insert([
                
                'id_empresa'            =>    $id_empresa = session('id_DBDEM'),                
                'nombre'                =>    $request->nombre,
                'usuario'               =>    $request->usuario,
                'clave'                 =>    $request->clave,
                'estado_agente'             =>    '1'  
                //'fecha_creacion'        =>    $fecha_creacion  
         ]);
       
            //si todo funciona correctamente deberia retornar usuario creado correctamente
         Session::flash('message','Agente ' .$request->usuario. ' creado correctamente');
         return redirect()->route('Agentes.index');
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
         $listarAgentes = DB::table('agente')->where('id',$id)->first();

        
                      
        return view('/Administrator/Agentes.edit', compact('listarAgentes'));
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
                
                'nombre'                 =>    'required',                
                'usuario'                =>    'required',
                'clave'               =>    'required'
                
         ]);
         //esta array inserta los datos en la tabla usuario
         DB::table('agente')->where('id', $id)->update([
                
                'id_empresa'            =>    $id_empresa = session('id_DBDEM'),                
                'nombre'                =>    $request->nombre,
                'usuario'               =>    $request->usuario,
                'clave'                 =>    $request->clave,
                'id_estado'             =>    '1'  
         ]);
       
            //si todo funciona correctamente deberia retornar usuario creado correctamente
         Session::flash('message','Agente ' .$request->usuario. ' Actualizado correctamente');
         return redirect()->route('Agentes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $agente = DB::table('agente')->where('id',$id)->first();

        DB::table('agente')->where('id', $id)->update([                
                
                'estado_agente'        =>    '0',  
                
         ]);

        Session::flash('message','Agente ' .$agente->usuario. ' Eliminado  correctamente');
         return redirect()->route('Agentes.index');
    }
}
