<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

class ControllerUsers extends Controller
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
        $listausuarios = DB::table('usuarios')->where('id_tipo_usuario',$id_DBDT = session('id_DBDEM'))->where('estado','1')->get();
        //MENU DINAMICO
        
        return view('/Administrator/Users.index', compact('listausuarios'));

        //return view('/Administrator/Users.index');
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
        
       $listaEmpresa = DB::table('empresa')->where('id',$id_DBDT = session('id_DBDEM'))->get();
       



        

       return view('/Administrator/Users.create', compact('listaEmpresa'));
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


                $usuario = DB::table('usuarios')->where('usuario',$request->Usuario)->orWhere('rut',$request->rut)->first();

       
       
       //  if ($usuario->usuario == $request->Usuario || $usuario->rut == $request->rut) {

       //     Session::flash('message','Usuario ya se encuentra creado');
       //   return redirect()->route('Users.index');

       // }else {
         $request->validate([            
                
                'Usuario'       =>    'required',                
                'password'      =>    'required',
                'nombre'        =>    'required',
                'apellido'      =>    'required',
                'rut'           =>    'required',
                'dv'            =>    'required',
                
         ]);
         //esta array inserta los datos en la tabla usuario
         DB::table('usuarios')->insert([
                'id_tipo_usuario'       =>    '1',
                'id_empresa'            =>    $id_empresa = session('id_DBDEM'),
                'estado'                =>    '1',  
                'Usuario'               =>    $request->Usuario,
                'password'              =>    $request->password,
                'nombre'                =>    $request->nombre,
                'apellido'              =>    $request->apellido,
                'rut'                   =>    $request->rut,
                'dv'                    =>    $request->dv
         ]);
       
            //si todo funciona correctamente deberia retornar usuario creado correctamente
         Session::flash('message','Usuario ' .$request->Usuario. ' creado correctamente');
         return redirect()->route('Users.index');
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
        
         $listarusuarios = DB::table('usuarios')->where('id_usuario',$id)->first();

        
                      
        return view('/Administrator/Users.edit', compact('listarusuarios'));
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
                
                'Usuario'       =>    'required',                
                'password'      =>    'required',
                'nombre'        =>    'required',
                'apellido'      =>    'required',
                'rut'           =>    'required',
                'dv'            =>    'required',
                
         ]);
         //esta array inserta los datos en la tabla usuario
         DB::table('usuarios')->where('id_usuario', $id)->update([
                
                'id_tipo_usuario'       =>    '1',
                'id_empresa'            =>    $id_empresa = session('id_DBDEM'),
                'estado'                =>    '1',  
                'Usuario'               =>    $request->Usuario,
                'password'              =>    $request->password,
                'nombre'                =>    $request->nombre,
                'apellido'              =>    $request->apellido,
                'rut'                   =>    $request->rut,
                'dv'                    =>    $request->dv
         ]);
       
            //si todo funciona correctamente deberia retornar usuario creado correctamente
         Session::flash('message','Usuario ' .$request->Usuario. ' Actualizado correctamente');
         return redirect()->route('Users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $usuarios = DB::table('usuarios')->where('id_usuario',$id)->first();

        DB::table('usuarios')->where('id_usuario', $id)->update([                
                
                'estado'                =>    '0',  
                
         ]);

        Session::flash('message','Usuario ' .$usuarios->usuario. ' Eliminado  correctamente');
         return redirect()->route('Users.index');
    }
}
