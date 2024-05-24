<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

class ControllerLogin extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Administrator.login');
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
        $request->validate([            
                
        
        'Usuario'          =>    'required',
        'Clave'            =>    'required'
                      
        
         ]);

       $usuario = DB::table('usuarios')    
        ->where('usuario',$request->Usuario)
        ->where('password',$request->Clave)->first();
       

        if ($usuario == '') {
                Session::flash('message',' Usuario o Contraseña Incorrecto');
                 //return view('login.index');
               //return redirect()->route('login.index');
              return redirect()->back();

            }else{
                if ($usuario->id_tipo_usuario == 1) {
                   // return view('menu.index');
                   
                    //return redirect()->action('App\Http\Controllers\ControllerMenu@index');
                    //return redirect()->route('Administrator/Menu.index');    
                    
                    //return 'el usuario es administrador';
                    // session(['UserTipo' => 'Administrador']);//TIPO ADMINISTRADOR
                     session(['id_DBDT' => $usuario->id_tipo_usuario]);// ID TIPO DE USUARIO
                     session(['id_DBDEM' => $usuario->id_empresa]);//ID DE LA EMPRESA
                    // session(['id_Usuario' => $usuario->Usuario]);//NOMBRE DE USUARIO
                    // session(['tel' => $request->anexo]);//ANEXO
                    // session(['DBIDUS' => $usuario->DBIDUS]);//IDUSUARIO
                       
                    
                return redirect()->route('Menu.index');
                    //return view('Administrator/Menu.index');
                          


                }else{
                    Session::flash('message',' Error al Ingresar, Ingrese datos correctos');
                
                //return view('login.index');
                //return redirect()->route('login.index');
                 return redirect()->back(); 
                    //return view('Administrator.login.login');
                }
                
            }    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $request->validate([            
                
        
        'Usuario'          =>    'required',
        'Clave'            =>    'required',
        'anexo'              
        
         ]);

       $usuario = DB::table('usuario')    
        ->where('Usuario',$request->Usuario)
        ->where('Clave',$request->Clave)->first();
       

        if ($usuario == '') {
                Session::flash('message',' Usuario o Contraseña Incorrecto');
                return redirect()->route('Login.index');
            }else{
                if ($usuario->DBIDT == 1 || $usuario->DBIDT == 4) {
                    //return 'el usuario es administrador';
                    session(['UserTipo' => 'Administrador']);//TIPO ADMINISTRADOR
                    session(['id_DBDT' => $usuario->DBIDT]);// ID TIPO DE USUARIO
                    session(['id_DBDEM' => $usuario->DBIDEM]);//ID DE LA EMPRESA
                    session(['id_Usuario' => $usuario->Usuario]);//NOMBRE DE USUARIO
                    session(['tel' => $request->anexo]);//ANEXO
                    session(['DBIDUS' => $usuario->DBIDUS]);//IDUSUARIO

                     //return view('menu.index');
                return redirect()->route('menu.index');
                    // $id_DBDT = session('id_Usuario');
                    // $id_DBDEM = session($usuario->DBIDEM);
                    // $id_Usuario = session($usuario->Usuario);        


                }
                if ($usuario->DBIDT == 2) {

                //     if ($usuario->DBIDT == 2 AND $request->anexo == '') {
                //        Session::flash('message',' El Campo Anexo no puede ser vacio, Ingrese su anexo');
                // return redirect()->route('Login.index');
                //     }
                   //return 'el usuario es Supervisor';
                    session(['UserTipo' => 'Supervisor']);
                    session(['id_DBDT' => $usuario->DBIDT]);
                    session(['id_DBDEM' => $usuario->DBIDEM]);
                    session(['id_Usuario' => $usuario->Usuario]);
                    session(['tel' => $request->anexo]);//ANEXO
                    session(['DBIDUS' => $usuario->DBIDUS]);//IDUSUARIO
                    // {{route('tiempoReal.index')}}
                    return redirect()->route('tiempoReal.index');
                    // $id_DBDT = session($usuario->DBIDT);
                    // $id_DBDEM = session($usuario->DBIDEM);
                    // $id_Usuario = session($usuario->Usuario);
                }
                if ($usuario->DBIDT == 3) {
                    //return 'el usuario es Agente';
                    session(['UserTipo' => 'Agente']);
                    session(['id_DBDT' => $usuario->DBIDT]);
                    session(['id_DBDEM' => $usuario->DBIDEM]);
                    session(['id_Usuario' => $usuario->Usuario]);
                    session(['tel' => $request->anexo]);//ANEXO
                    session(['DBIDUS' => $usuario->DBIDUS]);//IDUSUARIO
                    return view('menu.index');
                    // $id_DBDT = session($usuario->DBIDT);
                    // $id_DBDEM = session($usuario->DBIDEM);
                    // $id_Usuario = session($usuario->Usuario);
                }
                if ($usuario->DBIDT == 4) {
                    //return 'el usuario es Agente';
                    session(['UserTipo' => 'SuperAdmin']);
                    session(['id_DBDT' => $usuario->DBIDT]);
                    session(['id_DBDEM' => $usuario->DBIDEM]);
                    session(['id_Usuario' => $usuario->Usuario]);
                    session(['tel' => $request->anexo]);//ANEXO
                    session(['DBIDUS' => $usuario->DBIDUS]);//IDUSUARIO
                    return view('menu.index');
                    // $id_DBDT = session($usuario->DBIDT);
                    // $id_DBDEM = session($usuario->DBIDEM);
                    // $id_Usuario = session($usuario->Usuario);
                }
                if ($usuario->DBIDT == 5) {
                    //return 'el usuario es Agente';
                    session(['UserTipo' => 'Report']);
                    session(['id_DBDT' => $usuario->DBIDT]);
                    session(['id_DBDEM' => $usuario->DBIDEM]);
                    session(['id_Usuario' => $usuario->Usuario]);
                    session(['tel' => $request->anexo]);//ANEXO
                    session(['DBIDUS' => $usuario->DBIDUS]);//IDUSUARIO
                    return redirect()->route('reportes.index');
                    //return view('reportes.index');
                    // $id_DBDT = session($usuario->DBIDT);
                    // $id_DBDEM = session($usuario->DBIDEM);
                    // $id_Usuario = session($usuario->Usuario);
                }
            }    

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
        Session::flush();
        Session::flash('message',' Sesión Cerrada Correctamente');
           return redirect()->route('login.index');
    }
}
