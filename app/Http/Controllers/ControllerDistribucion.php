<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

class ControllerDistribucion extends Controller
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
        // $listaDistribucion = DB::table('agente')->where('id_empresa',$id_DBDT = session('id_DBDEM'))->where('estado_agente','1')->get();
        //MENU DINAMICO


        $listaDistribucion = DB::table('distribucion')
        ->select(   'distribucion.id as id_distribucion',
                    'ventana.nombre as nombre_ventana',
                    'mision.nombre as nombre_mision',
                    'mision.letra_ticket',
                    'distribucion.prioridad',
                    'distribucion.fecha_creacion',
                    'mision.id as id_mision',
                    'ventana.id as id_ventana')
        ->join('mision', 'distribucion.id_mision', '=', 'mision.id')
         ->join('ventana', 'distribucion.id_ventana', '=', 'ventana.id')
        ->where('distribucion.estado_distribucion', '1')
        ->get();
        //->where('usuario.DBIDUS', $id)->first();
        //return $listaDistribucion;
        return view('/Administrator/Distribucion.index', compact('listaDistribucion'));
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
        
       $misiones = DB::table('mision')->where('id_empresa',$id_DBDT = session('id_DBDEM'))->get();

       $ventanas = DB::table('ventana')->where('id_empresa',$id_DBDT = session('id_DBDEM'))->get();
       



        

       return view('/Administrator/Distribucion.create', compact('misiones','ventanas'));
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
        //return  $request;
      $fecha_creacion = date("Y-m-d H:i:s");

         $request->validate([            
                
                'id_ventana'              =>    'required',                
                'id_mision'               =>    'required',
                'prioridad'               =>    'required'
                
                
         ]);
         //esta array inserta los datos en la tabla usuario
         DB::table('distribucion')->insert([
                
                'id_ventana'               =>    $request->id_ventana,                
                'id_mision'                =>    $request->id_mision,
                'prioridad'                =>    $request->prioridad
                
         ]);
       
            //si todo funciona correctamente deberia retornar usuario creado correctamente
         Session::flash('message','Distribución creada correctamente');
         return redirect()->route('Distribucion.index');
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
        
        $listarDistribucion = DB::table('distribucion')->where('id',$id)->first();


         $Listarmisiones = DB::table('mision')->where('id',$listarDistribucion->id_mision)->first();

         $Listarventanas = DB::table('ventana')->where('id',$listarDistribucion->id_ventana)->first();

         $misiones = DB::table('mision')->where('id_empresa',$id_DBDT = session('id_DBDEM'))->get();

       $ventanas = DB::table('ventana')->where('id_empresa',$id_DBDT = session('id_DBDEM'))->get();
               
                      
        return view('/Administrator/Distribucion.edit', compact('listarDistribucion','Listarventanas','Listarmisiones','misiones','ventanas'));
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
       // return $request;
       $request->validate([            
                
                'id_ventana'               =>    'required',                
                'id_mision'                =>    'required',
                'prioridad'                =>    'required'
                
         ]);
         //esta array inserta los datos en la tabla usuario
         DB::table('distribucion')->where('id', $id)->update([
                
                'id_ventana'               =>    $request->id_ventana,                
                'id_mision'                =>    $request->id_mision,
                'prioridad'                =>    $request->prioridad  
         ]);
       
            //si todo funciona correctamente deberia retornar usuario creado correctamente
         Session::flash('message','Distribucion Actualizada correctamente');
         return redirect()->route('Distribucion.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $distribucion = DB::table('distribucion')->where('id',$id)->first();

        DB::table('distribucion')->where('id', $id)->update([                
                
                'estado_distribucion'        =>    '0'
                
         ]);

        Session::flash('message','Distribución ' .$distribucion->id. ' Eliminada  correctamente');
         return redirect()->route('Distribucion.index');
    }
}
