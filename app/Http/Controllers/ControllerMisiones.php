<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

class ControllerMisiones extends Controller
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
        $listaMisiones = DB::table('mision')->where('id_empresa',$id_DBDT = session('id_DBDEM'))->where('estado_mision','1')->get();
        //MENU DINAMICO
        
        return view('/Administrator/Misiones.index', compact('listaMisiones'));
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
        
       $listaMisiones = DB::table('mision')->where('id',$id_DBDT = session('id_DBDEM'))->get();
       



        

       return view('/Administrator/Misiones.create', compact('listaMisiones'));
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
      
    //    $mision = DB::table('mision')->where('nombre',$request->Usuario)->orWhere('letra_ticket',$request->letra_ticket)->first();

        
       
    // if ($mision->nombre <> '' || $mision->letra_ticket <> '') {

    //        Session::flash('message','mision ya se encuentra creada');
    //      return redirect()->route('Misiones.index');

    //     }else{
        $fecha_creacion = date("Y-m-d H:i:s");

         $request->validate([            
                
                'nombre'                 =>    'required',                
                
                'letra_ticket'           =>    'required'
               
               
                
                
         ]);
         $array=['Deposito-Atencion-General','Retiro Contenedor Full','Retiro Contenedor Vacio','Entrega Contenedor Full','Entrega Contenedor Vacio'];
         //esta array inserta los datos en la tabla usuario
         DB::table('mision')->insert([
                
                'id_empresa'            =>    $id_empresa = session('id_DBDEM'),                
                'nombre'                =>    $request->nombre,
                'tipo_contenedor'       =>    $request->tipo_contenedor,
                'letra_ticket'          =>    $request->letra_ticket,
                'horario'               =>    $request->horario,
                'mision_puerto'         =>    $request->tipo_mision,
                'estado_mision'         =>    1,
                'ingreso_directo'       =>    1,
                'nombre_puerto'         =>    $array[$request->tipo_mision],
         ]);
       
            //si todo funciona correctamente deberia retornar usuario creado correctamente
         Session::flash('message','Mision ' .$request->nombre. ' creada correctamente');
         return redirect()->route('Misiones.index');
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
       
         $listarmision = DB::table('mision')->where('id',$id)->first();

        
                      
        return view('/Administrator/Misiones.edit', compact('listarmision'));
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
            
            'letra_ticket'           =>    'required',
            
                
         ]);
         //esta array inserta los datos en la tabla usuario
         DB::table('mision')->where('id', $id)->update([
                
                'id_empresa'            =>    $id_empresa = session('id_DBDEM'),                
                'nombre'                =>    $request->nombre,
                'tipo_contenedor'       =>    $request->tipo_contenedor,
                'letra_ticket'          =>    $request->letra_ticket,
                'horario'               =>    $request->horario,  
         ]);
       
            //si todo funciona correctamente deberia retornar usuario creado correctamente
         Session::flash('message','Misión ' .$request->nombre. ' Actualizada correctamente');
         return redirect()->route('Misiones.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $mision = DB::table('mision')->where('id',$id)->first();

        DB::table('mision')->where('id', $id)->update([                
                
                'estado_mision'        =>    '0',  
                
         ]);

        Session::flash('message','Mision ' .$mision->nombre. ' Eliminado  correctamente');
         return redirect()->route('Misiones.index');
    }
}
