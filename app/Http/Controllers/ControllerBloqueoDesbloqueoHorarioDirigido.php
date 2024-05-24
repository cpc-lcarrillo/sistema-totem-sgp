<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
class ControllerBloqueoDesbloqueoHorarioDirigido extends Controller
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
            $DesbloqueoHorarioDirigido = DB::table('bloqueo_horario')->where('horario_fijo_bloq_horario','0')->orderBy('fecha_bloq_horario','hora_inicio_bloq_horario','ASC')->get();
            //MENU DINAMICO
            
            return view('/Administrator/DesbloqueoHorarioDirigido.index', compact('DesbloqueoHorarioDirigido'));
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
            
           //$listaEmpresa = DB::table('empresa')->where('id',$id_DBDT = session('id_DBDEM'))->get();
           
    
    
    
            
    
           //return view('/Administrator/Users.create', compact('listaEmpresa'));

           return view('/Administrator/DesbloqueoHorarioDirigido.create');

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
        //return $request->Bloqueo;
        
        // "FECHA": "2022-11-16",
        // "INICIO": "12:00:00",
        // "FIN": "13:00:00",
        // "Bloqueo": "on"
        $bloqueo = DB::table('bloqueo_horario')->get();
        //return $request;
        if($request->Bloqueo == "on"){
            
            $bloq_horario=1;
            //return "es on".$bloq_horario;
        }else{
            $bloq_horario=0;
            //return "es OFF".$bloq_horario;
        }


        //return $bloq_horario;
        //return $request;
        $Inicio = strtotime($request->INICIO);
        $fin = strtotime($request->FIN );

        if($Inicio > $fin){
            $mensaje="EL Horario de Inicio no puede ser inferior a Horario Fin";
                Session::flash('message',$mensaje);
                return redirect()->back();
        }else{      
             
        
        
        $activado_bloque=0; ///activa bloqueo de horario 0: imprime & 1: no imprime
        $horarioFijoActivo=0;
        $bloqueoDesbloqueoDirigido=1;
        $mensaje="";
        $fechaActual =date("Y-m-d");
        $HoraActual =date("H:i:s");
        //$HoraActual ="21:10:00";
        $bloqueo = DB::table('bloqueo_horario')->get(); 
        //$bloqueo = DB::table('bloqueo_horario')->where('horario_fijo_bloq_horario','0')->get();
        $id_bloq_horario_Validacion=0;
        //return $bloqueo;
            ////FOR de BLOQUEO FIJO
            //echo $request->INICIO."***".$request->FIN."<br>";
            $bloqueo_fijo = DB::table('bloqueo_horario')->where('horario_fijo_bloq_horario','1')->get(); 
            $bloqueo = DB::table('bloqueo_horario')->where('horario_fijo_bloq_horario','0')->get();
            //return $bloqueo;
                ////FOR de BLOQUEO FIJO
            for($i=0; $i< $data=count($bloqueo_fijo); $i++  ){
                
                if(($bloqueo_fijo[$i]->hora_inicio_bloq_horario  <= $request->INICIO) && ($bloqueo_fijo[$i]->hora_fin_bloq_horario  >= $request->FIN) ){
                    //echo $bloqueo_fijo[$i]->hora_inicio_bloq_horario."id_registro:".$bloqueo_fijo[$i]->id_bloq_horario."<br>";
                    $horarioFijoActivo=1; //NO Puede imprimir
                    //echo "id_bloq_horario_fijo".$bloqueo_fijo[$i]->id_bloq_horario."<br>";
                    break;
                    $i++;
                    //$mensaje="Totem Deshabilitado, Acerquese a ventanillas para mas información";
                }
                
                // if(){
                //     //echo $bloqueo_fijo[$i]->hora_inicio_bloq_horario."id_registro:".$bloqueo_fijo[$i]->id_bloq_horario."<br>";
                //     $horarioFijoActivo=1; //NO Puede imprimir
                //     //echo "id_bloq_horario_fijo".$bloqueo_fijo[$i]->id_bloq_horario."<br>";
                //     break;
                //     $i++;
                //     //$mensaje="Totem Deshabilitado, Acerquese a ventanillas para mas información";
                // }
                        
                
            }
            
             

                                        
        //     ///FOR DE BLOQUEO Y DESBLOQUEO DIRIGIDO
            for($i=0; $i< $data=count($bloqueo); $i++  ){
               
    
                        if ($bloqueo[$i]->fecha_bloq_horario == $request->FECHA && $bloqueo[$i]->horario_fijo_bloq_horario == 0 && $bloqueo[$i]->activa_bloqueo_bloq_horario == 1 && ($request->INICIO >= $bloqueo[$i]->hora_inicio_bloq_horario) && ($request->FIN <= $bloqueo[$i]->hora_fin_bloq_horario)) {
                        //valido que horario_fijo_bloq_horario=0 y activa bloqueo este en 1: no imprime
                        //////echo "no imprime id:".$bloq->id_bloq_horario;
                        //echo "id_bloq_horario_dirigido".$bloqueo[$i]->id_bloq_horario."<br>";
                        $activado_bloque=1;
                        //$mensaje="Totem Deshabilitado, Acerquese a ventanillas para mas información";
                        $bloqueoDesbloqueoDirigido=1;
                        $id_bloq_horario_Validacion=$bloqueo[$i]->id_bloq_horario;
    
    
    
                      } elseif ($bloqueo[$i]->fecha_bloq_horario == $request->FECHA  && $bloqueo[$i]->horario_fijo_bloq_horario == 0 && $bloqueo[$i]->activa_bloqueo_bloq_horario == 0 && ($request->INICIO >= $bloqueo[$i]->hora_inicio_bloq_horario) && ($request->FIN <= $bloqueo[$i]->hora_fin_bloq_horario)) {
                        //valido que horario_fijo_bloq_horario=0 y activa bloqueo este en 0: Imprime
                        //////echo "imprime id:".$bloq->id_bloq_horario;
                        //echo "id_bloq_horario_dirigido".$bloqueo[$i]->id_bloq_horario."<br>";
                        $activado_bloque=0;
                        //$mensaje="Totem Habilitado";
                        $bloqueoDesbloqueoDirigido=0;
                        $id_bloq_horario_Validacion=$bloqueo[$i]->id_bloq_horario;
                        //return "CAE AQUI EN 0";
                        //$mensaje="TOTEM DESHABILITADO, ACERQUESE A VENTANILLA PARA MAS INFORMACIÓN";
                    }else{
                        //no encuentra horario deja en esta de habilitado
                        //echo "horario es fijo ".$HoraActual.$bloq->hora_inicio_bloq_horario."*******".$bloq->hora_fin_bloq_horario."<br>";
                        //$activado_bloque=1;//no imprime
                        //$mensaje="Totem Habilitado no se encuentran bloqueos y desbloqueos dirigidos";
                        $bloqueoDesbloqueoDirigido=3; 
                        $id_bloq_horario_Validacion=$bloqueo[$i]->id_bloq_horario;
                        // return "id_bloq_horario_dirigido".$bloqueo[$i]->id_bloq_horario."<br>";         
                    }
                    if(($bloqueo[$i]->hora_inicio_bloq_horario >=  $request->INICIO) && ($bloqueo[$i]->hora_fin_bloq_horario <= $request->FIN)){
                        //return"ESTA DENTRO__".$bloqueo[$i]->id_bloq_horario."-----".$bloqueo[$i]->hora_inicio_bloq_horario."----".$bloqueo[$i]->hora_fin_bloq_horario;
                        $bloqueoDesbloqueoDirigido=1;
                        $bloq_horario_DB=$bloqueo[$i]->activa_bloqueo_bloq_horario ;
                        //return "CAE aQUI1111";
                    }
                        
    
            }
                
                    //return $bloqueoDesbloqueoDirigido;
                                       
            //return $horarioFijoActivo."  ".$bloqueoDesbloqueoDirigido.$bloq_horario."<br>";
    
            /// CASOS CON BLOQUEO FIJO ACTIVO // que no pueda imprimir
           if ($horarioFijoActivo==1 && $bloqueoDesbloqueoDirigido==1) {
                //echo "hay un bloqueo fijo y un bloqueo dirigido";
                //return "CAE AQUI1";
                //return $bloq_horario;
                if($bloq_horario == 0){

                    //return "CAE AQUI2";
                    $request->validate([            
                        'FECHA'                 =>    'required',
                        'INICIO'                 =>    'required',
                        'FIN'                    =>    'required'
                       
                      
                         ]);
              
                       DB::table('bloqueo_horario')->insert([
                       'fecha_bloq_horario'          =>    $request->FECHA,
                       'hora_inicio_bloq_horario'    =>    $request->INICIO,
                       'hora_fin_bloq_horario'       =>    $request->FIN,
                       'horario_fijo_bloq_horario'   =>    '0',
                       'activa_bloqueo_bloq_horario' =>    $bloq_horario
                       
                       ]);
              
                   
                 Session::flash('message','Bloqueo/Desbloqueo Horario Dirigido HoraInicio: '.$request->INICIO.' HoraFin: '.$request->FIN.' Creado Exitosamente');
                 return redirect()->route('DesbloqueoHorarioDirigido.index');
                }else{
                //return "CAE AQUI3";
                    $activado_bloque=1; //no deja imprimir                
                    $mensaje="No se puede Activar bloqueo por que ya existe un Bloque Horario Fijo";
                    //$mensaje="Ya existe Registro de un Bloque Horario Fijo y un bloqueo Dirigido";
                Session::flash('message',$mensaje);
                return redirect()->back();
                }
                ///return $horarioFijoActivo."   ".$bloqueoDesbloqueoDirigido;
                
           }
           if ($horarioFijoActivo==1 && $bloqueoDesbloqueoDirigido==0) {
            //return "CAE AQUI4";
                //echo "hay un bloqueo fijo y un desbloqueo dirigido";
                $activado_bloque=0; //SI deja imprimir
                $mensaje="Ya existe Registro de un Bloque Horario Fijo y un desbloqueo dirigido";
                Session::flash('message',$mensaje);
                return redirect()->back();
           }
           
           if ($horarioFijoActivo==1 && $bloqueoDesbloqueoDirigido==3) {
            //12:00 a 13:00
            //return "CAE AQUI8888  ".$bloq_horario;
            if($bloq_horario == 1){
                //return "CAE AQUI5";
                $mensaje="Solo se permiten desbloqueos cuando existe un horario fijo activado";
                Session::flash('message',$mensaje);
                return redirect()->back();
            }else{
                //return "CAE AQUI6__".$id_bloq_horario_Validacion;
                
                $bloqueoValidacion = DB::table('bloqueo_horario')->Where('id_bloq_horario',$id_bloq_horario_Validacion)->first();
                //return $bloqueoValidacion;
                if (empty($bloqueoValidacion)) {
                    //echo "Solo hay un bloqueo fijo";
                $activado_bloque=1; //NO deja imprimir
                $mensaje="Ya Existe un registro Horario Fijo";
                $request->validate([            
                    'FECHA'                 =>    'required',
                    'INICIO'                 =>    'required',
                    'FIN'                    =>    'required'
                   
                  
                     ]);
          
                   DB::table('bloqueo_horario')->insert([
                   'fecha_bloq_horario'          =>    $request->FECHA,
                   'hora_inicio_bloq_horario'    =>    $request->INICIO,
                   'hora_fin_bloq_horario'       =>    $request->FIN,
                   'horario_fijo_bloq_horario'   =>    '0',
                   'activa_bloqueo_bloq_horario' =>    $bloq_horario
                   
                   ]);
          
               
             Session::flash('message','Bloqueo/Desbloqueo Horario Dirigido HoraInicio: '.$request->INICIO.' HoraFin: '.$request->FIN.' Creado Exitosamente');
             return redirect()->route('DesbloqueoHorarioDirigido.index');
                }else{
                    $mensaje="Solo se permiten desbloqueos cuando existe un horario fijo activado";
                Session::flash('message',$mensaje);
                return redirect()->back();
                }
                
            }
           }
           ///CASOS CON BLOQUEO FIJO DESACTIVADO //Que si pueda imprimir
           if ($horarioFijoActivo==0 && $bloqueoDesbloqueoDirigido==1) {
            //return "CAE AQUI7";
            $bloqueo_fijo = DB::table('bloqueo_horario')->where('horario_fijo_bloq_horario','1')->get(); 
            $bloqueoValidacion = DB::table('bloqueo_horario')->where('horario_fijo_bloq_horario','0')->where('activa_bloqueo_bloq_horario','1')->first();
                //return $bloqueoValidacion
                if (empty($bloqueoValidacion)) {
                    //return "CAE AQUI8";
                    //return "SE INSERTA POR QUE LA DB ESTA VACIA";
                    $request->validate([            
                        'FECHA'                 =>    'required',
                        'INICIO'                 =>    'required',
                        'FIN'                    =>    'required'
                       
                      
                         ]);
              
                       DB::table('bloqueo_horario')->insert([
                       'fecha_bloq_horario'          =>    $request->FECHA,
                       'hora_inicio_bloq_horario'    =>    $request->INICIO,
                       'hora_fin_bloq_horario'       =>    $request->FIN,
                       'horario_fijo_bloq_horario'   =>    '0',
                       'activa_bloqueo_bloq_horario' =>    $bloq_horario
                       
                       ]);
              
                   
                 Session::flash('message','Bloqueo/Desbloqueo Horario Dirigido HoraInicio: '.$request->INICIO.' HoraFin: '.$request->FIN.' Creado Exitosamente');
                 return redirect()->route('DesbloqueoHorarioDirigido.index');
                }else{
                    //return "CAE AQUI9";
                    //echo "NO hay un bloqueo fijo y un bloqueo dirigido";
                $activado_bloque=1; //NO deja imprimir
                //return $horarioFijoActivo."error aqui".$bloqueoDesbloqueoDirigido;
                $mensaje="Ya existe Registro de un desbloqueo dirigido";
                Session::flash('message',$mensaje);
                return redirect()->back();
                }
            
            
           }
            if ($horarioFijoActivo==0 && $bloqueoDesbloqueoDirigido==0) {
                $bloqueoValidacion = DB::table('bloqueo_horario')->where('horario_fijo_bloq_horario','0')->where('activa_bloqueo_bloq_horario','0')->where('fecha_bloq_horario',$request->FECHA)->select(DB::raw('count(*) as bloqueoValidacion'))->first();
                //return $bloqueoValidacion->bloqueoValidacion;
                if ($bloqueoValidacion->bloqueoValidacion < 1) {

                    //return "CAE AQUI10";
                    //echo "NO hay un bloqueo fijo y un desbloqueo dirigido";
                    $activado_bloque=0; //SI deja imprimir
                    //$mensaje="Totem Habilitado";
                    $request->validate([            
                        'FECHA'                 =>    'required',
                        'INICIO'                 =>    'required',
                        'FIN'                    =>    'required'
                       
                      
                         ]);
              
                       DB::table('bloqueo_horario')->insert([
                       'fecha_bloq_horario'          =>    $request->FECHA,
                       'hora_inicio_bloq_horario'    =>    $request->INICIO,
                       'hora_fin_bloq_horario'       =>    $request->FIN,
                       'horario_fijo_bloq_horario'   =>    '0',
                       'activa_bloqueo_bloq_horario' =>    $bloq_horario
                       
                       ]);
              
                   
                 Session::flash('message','Bloqueo/Desbloqueo Horario Dirigido HoraInicio: '.$request->INICIO.' HoraFin: '.$request->FIN.' Creado Exitosamente');
                 return redirect()->route('DesbloqueoHorarioDirigido.index');    
                }else{
                    $activado_bloque=1; //NO deja imprimir
                    //return $horarioFijoActivo."error aqui".$bloqueoDesbloqueoDirigido;
                    $mensaje="Ya existe Registro de un desbloqueo dirigido";
                    Session::flash('message',$mensaje);
                    return redirect()->back();
                }
               
           }
            if ($horarioFijoActivo==0 && $bloqueoDesbloqueoDirigido==3) {
                //return "CAE AQUI11";
                $bloq_horario_DB = 0;
                for($i=0; $i< $data=count($bloqueo); $i++  ){
                    //return $bloqueo[$i]->id_bloq_horario."-----".$bloqueo[$i]->hora_inicio_bloq_horario."----".$bloqueo[$i]->hora_fin_bloq_horario;
                    
                    if ($bloqueo[$i]->fecha_bloq_horario == $request->FECHA && $bloqueo[$i]->horario_fijo_bloq_horario == 0 && $bloqueo[$i]->activa_bloqueo_bloq_horario == 1 && ($bloqueo[$i]->hora_inicio_bloq_horario >= $request->INICIO) && ($bloqueo[$i]->hora_fin_bloq_horario <=  $request->FIN )) {
                    //valido que horario_fijo_bloq_horario=0 y activa bloqueo este en 1: no imprime
                    //////echo "no imprime id:".$bloq->id_bloq_horario;
                    //echo "id_bloq_horario_dirigido".$bloqueo[$i]->id_bloq_horario."<br>";
                    //return $bloqueo[$i]->activa_bloqueo_bloq_horario;
                    $activado_bloque=1;
                    //$mensaje="Totem Deshabilitado, Acerquese a ventanillas para mas información";
                    $bloqueoDesbloqueoDirigido=1;
                    $bloq_horario_DB=$bloqueo[$i]->activa_bloqueo_bloq_horario ;


                  } 
                  if ($bloqueo[$i]->fecha_bloq_horario == $request->FECHA && $bloqueo[$i]->horario_fijo_bloq_horario == 0 && $bloqueo[$i]->activa_bloqueo_bloq_horario == 0 && ($bloqueo[$i]->hora_inicio_bloq_horario >= $request->INICIO) && ($bloqueo[$i]->hora_fin_bloq_horario <=  $request->FIN )) {
                    $bloqueoDesbloqueoDirigido=1;
                    $bloq_horario_DB=$bloqueo[$i]->activa_bloqueo_bloq_horario ;
                  } 
                  
                  if ($bloqueo[$i]->fecha_bloq_horario == $request->FECHA && $bloqueo[$i]->horario_fijo_bloq_horario == 0 && $bloqueo[$i]->activa_bloqueo_bloq_horario == 0 && ($request->INICIO >=  $bloqueo[$i]->hora_inicio_bloq_horario) && ($request->FIN  <= $bloqueo[$i]->hora_fin_bloq_horario)) {
                    $bloqueoDesbloqueoDirigido=1;
                    $bloq_horario_DB=$bloqueo[$i]->activa_bloqueo_bloq_horario ;
                  }   
                  
                  
                  if(($bloqueo[$i]->hora_inicio_bloq_horario >=  $request->INICIO) && ($bloqueo[$i]->hora_fin_bloq_horario <= $request->FIN)){
                    //return"ESTA DENTRO__".$bloqueo[$i]->id_bloq_horario."-----".$bloqueo[$i]->hora_inicio_bloq_horario."----".$bloqueo[$i]->hora_fin_bloq_horario;
                    $bloqueoDesbloqueoDirigido=1;
                    $bloq_horario_DB=$bloqueo[$i]->activa_bloqueo_bloq_horario ;
                }
        }
        //return $bloqueoDesbloqueoDirigido;
        //return $bloqueoDesbloqueoDirigido."----------".$bloq_horario."--------".$bloq_horario_DB;
        if($bloqueoDesbloqueoDirigido == 1 && $bloq_horario_DB == $bloq_horario){
            //return "CAE AQUI 3333";
            //return "bloqueo dirigido viene 1 y activa bloqueo es diferente de lo que que viene";
            $mensaje="Ya existe Registro de un desbloqueo dirigido";
                    Session::flash('message',$mensaje);
                    return redirect()->back();
        }else{
            
            // $bloqueoValidacion = DB::table('bloqueo_horario')->Where('id_bloq_horario',$id_bloq_horario_Validacion)->get();
            //     return $bloqueoValidacion;
            //     if (empty($bloqueoValidacion)) {
            //         return "CAE AQUI222";
            //     }else{
            //         return "CAE AQUI2223";
            //     }
        // return $bloqueoDesbloqueoDirigido;

                //echo "No Hay bloqueo fijo";
                $activado_bloque=0; //SI deja imprimir
                //$mensaje="Totem Habilitado";
                $request->validate([            
                    'FECHA'                 =>    'required',
                    'INICIO'                 =>    'required',
                    'FIN'                    =>    'required'
                   
                  
                     ]);
          
                   DB::table('bloqueo_horario')->insert([
                   'fecha_bloq_horario'          =>    $request->FECHA,
                   'hora_inicio_bloq_horario'    =>    $request->INICIO,
                   'hora_fin_bloq_horario'       =>    $request->FIN,
                   'horario_fijo_bloq_horario'   =>    '0',
                   'activa_bloqueo_bloq_horario' =>    $bloq_horario
                   
                   ]);
          
               
             Session::flash('message','Bloqueo/Desbloqueo Horario Dirigido HoraInicio: '.$request->INICIO.' HoraFin: '.$request->FIN.' Creado Exitosamente');
             return redirect()->route('DesbloqueoHorarioDirigido.index');
                }
           
            }
        //    echo $horarioFijoActivo."  ".$bloqueoDesbloqueoDirigido."<br>";

        //    echo "MSJ:".$mensaje." DEJA INSERTAR:".$activado_bloque;

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
        $eliminar_bloquehorariofijo = DB::table('bloqueo_horario')->where('id_bloq_horario',$id)->first(); 

        DB::table('bloqueo_horario')->where('id_bloq_horario',$id)->delete();
        //return $eliminar_bloquehorariofijo->hora_inicio_bloq_horario."***".$eliminar_bloquehorariofijo->hora_fin_bloq_horario;



        Session::flash('message','Bloqueo/Desbloqueo Horario Dirigido HoraInicio: ' .$eliminar_bloquehorariofijo->hora_inicio_bloq_horario. ' Hora Fin: '.$eliminar_bloquehorariofijo->hora_fin_bloq_horario.' Eliminado  correctamente');
         return redirect()->route('DesbloqueoHorarioDirigido.index');
    }
}
