<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

class ControllerTag extends Controller
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
        // $llamadas= DB::connection('mysql2')->select("CALL sp_reporte_callback($id_DBDEM,'$fechaInicio','$fechatermino','$agente')"); 
          // $listausuarios = DB::connection('mysql2')->DB::table('tag')->where('id_tipo_usuario',$id_DBDT = session('id_DBDEM'))->where('estado','1')->get();
        $listaTAG = DB::connection('mysql2')->table('tag')->get();
        //MENU DINAMICO
        
        return view('/Administrator/Tag.index', compact('listaTAG'));

        //return view('/Administrator/Users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('/Administrator/Tag.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        if ($request->estado == 1) {
           $request->validate([            
                
                'Cod_interno' =>    'required',                
                'EPC'         =>    'required',
                'patente'      =>    'required',
                'estado'      =>    'required'
                
         ]);
        }else{
            $request->validate([            
                
                'Cod_interno' =>    'required',                
                'EPC'         =>    'required',
                'patente',
                'estado'      =>    'required'
                
         ]);
        }

        

       DB::connection('mysql2')->table('tag')->insert([
                
                'Cod_interno'       =>    $request->Cod_interno,
                'EPC'               =>    $request->EPC,
                'patente'           =>    $request->patente,  
                'estado'            =>    $request->estado
         ]);
       
            //si todo funciona correctamente deberia retornar usuario creado correctamente
         Session::flash('message','EPC ' .$request->EPC. ' creado correctamente');
         return redirect()->route('Tag.index');
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
        $listarTAG = DB::connection('mysql2')->table('tag')->where('id',$id)->first();
        // $listarusuarios = DB::table('usuarios')->where('id_usuario',$id)->first();

        
                      
        return view('/Administrator/Tag.edit', compact('listarTAG'));
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
                
                'Cod_interno' =>    'required',                
                'EPC'         =>    'required',
                'patente'     =>    'required',
                'estado'      =>    'required'
                
         ]);

       if ($request->estado == 2) {
           DB::connection('mysql2')->table('tag')->where('id', $id)->update([
                
                'Cod_interno'       =>    $request->Cod_interno,
                'EPC'               =>    $request->EPC,
                'patente'           =>    '',  
                'estado'            =>    $request->estado
         ]);
       
            //si todo funciona correctamente deberia retornar usuario creado correctamente
         Session::flash('message','Patente ' .$request->patente. ' Actualizada correctamente');
         return redirect()->route('Tag.index');
       }else {
           # code...
      
         //esta array inserta los datos en la tabla usuario
         DB::connection('mysql2')->table('tag')->where('id', $id)->update([
                
                'Cod_interno'       =>    $request->Cod_interno,
                'EPC'               =>    $request->EPC,
                'patente'           =>    $request->patente,  
                'estado'            =>    $request->estado
         ]);
       
            //si todo funciona correctamente deberia retornar usuario creado correctamente
         Session::flash('message','Patente ' .$request->patente. ' Actualizada correctamente');
         return redirect()->route('Tag.index');
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
