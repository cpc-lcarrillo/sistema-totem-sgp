<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection as Collection;
use DB;
use Session;
class ControllerRegistroOCR extends Controller
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
            date_default_timezone_set('America/Santiago');
                                    //echo $hoy = date('d/m/Y g:ia');
                                    $fechaIngreso = date('Y-m-d');
            $controlEmisionTicket = DB::table('controlEmisionTicket')->where('fechaIngreso',$fechaIngreso)->where('generacionRegistro','M')->get();
            //MENU DINAMICO
            //return $controlEmisionTicket;
            return view('/Administrator/RegistroOCR.index', compact('controlEmisionTicket'));
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
            
           return view('/Administrator/RegistroOCR.create');
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
        
       
         $request->validate([            
                
                'PatenteTransporte'       =>    'required'              
                
                
         ]);
         //esta array inserta los datos en la tabla usuario
         date_default_timezone_set('America/Santiago');
         $fechaIngreso = date('Y-m-d');
         $horaIngreso = date('H:i:s');
        //  $fechatiempo = date('Y-m-d H:i:s');

                   DB::table('controlEmisionTicket')->insert([
                    'fechaIngreso'           =>    "$fechaIngreso",
                    'horaIngreso'            =>    "00:01:00",
                    'patenteTransporte'      =>    $request->PatenteTransporte,  
                    'statusEmision'          =>    "N",
                    'generacionRegistro'     =>    "M",
                    'fechaEmision'           =>    "$fechaIngreso"." "."$horaIngreso"

                    
                    ]);
       
            //si todo funciona correctamente deberia retornar usuario creado correctamente
         Session::flash('message','Patente ' .$request->PatenteTransporte. ' Ingresada correctamente');
         return redirect()->route('RegistroOCR.index');
       
       

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
        //$listarusuarios = DB::table('AdminOCR')->first();

        //return $listarusuarios->error_txt;
                      
        //return view('/Administrator/RegistroOCR.edit', compact('listarusuarios'));
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

        //$id=1;
        //return $id;
        $request->validate([            
                
            'error_txt'       =>    'required'                
            
            
     ]);
     //esta array inserta los datos en la tabla usuario
     DB::table('AdminOCR')->update([
            
                       
            'error_txt'                    =>    $request->error_txt
     ]);
   
        //si todo funciona correctamente deberia retornar usuario creado correctamente
     Session::flash('message','Mensaje Totem: ' .$request->error_txt. ' Actualizado correctamente');
     return redirect()->route('RegistroOCR.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //$usuarios = DB::table('usuarios')->where('id_usuario',$id)->first();

        DB::table('controlEmisionTicket')->where('idControlEmisionTicket', $id)->delete();

        Session::flash('message','Registro OCR ' .$id. ' Eliminado  correctamente');
         return redirect()->route('RegistroOCR.index');
    }
}
