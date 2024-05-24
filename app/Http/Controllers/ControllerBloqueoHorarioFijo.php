<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
class ControllerBloqueoHorarioFijo extends Controller
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
            $bloqueo_horario = DB::table('bloqueo_horario')->where('horario_fijo_bloq_horario','1')->orderBy('hora_inicio_bloq_horario','ASC')->get();
            //MENU DINAMICO
            
            return view('/Administrator/BloqueoHorarioFijo.index', compact('bloqueo_horario'));
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

           return view('/Administrator/BloqueoHorarioFijo.create');

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
                // else{
                //     $horarioFijoActivo=0; //SI Puede imprimir
                //     break;
                //     $i++;
                // }
                
                // if (($bloqueo_fijo[$i]->hora_inicio_bloq_horario  <= $HoraActual) && ($bloqueo_fijo[$i]->hora_fin_bloq_horario  >= $HoraActual) ) {
                //         //echo "horario fijo activado";
                //         $horarioFijoActivo=1; //NO Puede imprimir
                //         $mensaje="Totem Deshabilitado, Acerquese a ventanillas para mas información";
                //         //break;
                //         //continue;
                // }else{
                //     //echo "No hay horario fijo activado";
                //         $horarioFijoActivo=0; //SI Puede imprimir
                //         $mensaje="Totem Habilitado";
                        
                // }
                        
                
            }
            
            if($horarioFijoActivo == 1){
                 $mensaje="Ya existe Registro de este Horario Fijo o es Parte de Otro";
                 Session::flash('message',$mensaje);
                 return redirect()->back();
            }else{
                //echo $mensaje="NO Existe Registro de Horario Fijo";

                //echo $request->INICIO."***".$request->FIN."<br>";

                $request->validate([ 

                
                'INICIO'                 =>    'required',
                'FIN'                    =>    'required'
                
               
                  ]);
       
                DB::table('bloqueo_horario')->insert([
                'fecha_bloq_horario'          =>    $fechaActual = date("Y-m-d"),
                'hora_inicio_bloq_horario'    =>    $request->INICIO,
                'hora_fin_bloq_horario'       =>    $request->FIN,
                'horario_fijo_bloq_horario'   =>    '1',
                'activa_bloqueo_bloq_horario' =>    '1'
                
                ]);
       
            
          Session::flash('message','Bloqueo Horario Fijo HoraInicio: '.$request->INICIO.' HoraFin: '.$request->FIN.' Creado Exitosamente');
          return redirect()->route('BloqueoHorarioFijo.index');



                 //Session::flash('message',$mensaje);
                 //return redirect()->back();
            }

                                        
        //     ///FOR DE BLOQUEO Y DESBLOQUEO DIRIGIDO
        //     for($i=0; $i< $data=count($bloqueo); $i++  ){
               
    
        //                 if ($bloqueo[$i]->fecha_bloq_horario == $fechaActual && $bloqueo[$i]->horario_fijo_bloq_horario == 0 && $bloqueo[$i]->activa_bloqueo_bloq_horario == 1 && ($HoraActual >= $bloqueo[$i]->hora_inicio_bloq_horario) && ($HoraActual <= $bloqueo[$i]->hora_fin_bloq_horario)) {
        //                 //valido que horario_fijo_bloq_horario=0 y activa bloqueo este en 1: no imprime
        //                 //////echo "no imprime id:".$bloq->id_bloq_horario;
        //                 //echo "id_bloq_horario_dirigido".$bloqueo[$i]->id_bloq_horario."<br>";
        //                 $activado_bloque=1;
        //                 //$mensaje="Totem Deshabilitado, Acerquese a ventanillas para mas información";
        //                 $bloqueoDesbloqueoDirigido=1;
    
    
    
        //               } elseif ($bloqueo[$i]->fecha_bloq_horario == $fechaActual && $bloqueo[$i]->horario_fijo_bloq_horario == 0 && $bloqueo[$i]->activa_bloqueo_bloq_horario == 0 && ($HoraActual >= $bloqueo[$i]->hora_inicio_bloq_horario) && ($HoraActual <= $bloqueo[$i]->hora_fin_bloq_horario)) {
        //                 //valido que horario_fijo_bloq_horario=0 y activa bloqueo este en 0: Imprime
        //                 //////echo "imprime id:".$bloq->id_bloq_horario;
        //                 //echo "id_bloq_horario_dirigido".$bloqueo[$i]->id_bloq_horario."<br>";
        //                 $activado_bloque=0;
        //                 //$mensaje="Totem Habilitado";
        //                 $bloqueoDesbloqueoDirigido=0;
    
        //                 //$mensaje="TOTEM DESHABILITADO, ACERQUESE A VENTANILLA PARA MAS INFORMACIÓN";
        //             }else{
        //                 //no encuentra horario deja en esta de habilitado
        //                 //echo "horario es fijo ".$HoraActual.$bloq->hora_inicio_bloq_horario."*******".$bloq->hora_fin_bloq_horario."<br>";
        //                 //$activado_bloque=1;//no imprime
        //                 //$mensaje="Totem Habilitado no se encuentran bloqueos y desbloqueos dirigidos";
        //                 $bloqueoDesbloqueoDirigido=3; 
        //                 //echo "id_bloq_horario_dirigido".$bloqueo[$i]->id_bloq_horario."<br>";         
        //             }
                        
    
        //     }
    
                                       
    
    
        //     /// CASOS CON BLOQUEO FIJO ACTIVO // que no pueda imprimir
        //    if ($horarioFijoActivo==1 && $bloqueoDesbloqueoDirigido==1) {
        //         //echo "hay un bloqueo fijo y un bloqueo dirigido";
        //         $activado_bloque=1; //no deja imprimir
        //         $mensaje="Totem Deshabilitado, Acerquese a ventanillas para mas información";
        //    }
        //    if ($horarioFijoActivo==1 && $bloqueoDesbloqueoDirigido==0) {
        //         //echo "hay un bloqueo fijo y un desbloqueo dirigido";
        //         $activado_bloque=0; //SI deja imprimir
        //         $mensaje="Totem Habilitado";
        //    }
        //    if ($horarioFijoActivo==1 && $bloqueoDesbloqueoDirigido==3) {
        //         //echo "Solo hay un bloqueo fijo";
        //         $activado_bloque=1; //NO deja imprimir
        //         $mensaje="Ya Existe un registro Horario Fijo";
        //         //Session::flash('message',$mensaje);
        //         //return redirect()->back();
        //    }
        //    ///CASOS CON BLOQUEO FIJO DESACTIVADO //Que si pueda imprimir
        //    if ($horarioFijoActivo==0 && $bloqueoDesbloqueoDirigido==1) {
        //         //echo "NO hay un bloqueo fijo y un bloqueo dirigido";
        //         $activado_bloque=1; //NO deja imprimir
        //         $mensaje="Totem Deshabilitado, Acerquese a ventanillas para mas información";
        //    }
        //     if ($horarioFijoActivo==0 && $bloqueoDesbloqueoDirigido==0) {
        //         //echo "NO hay un bloqueo fijo y un desbloqueo dirigido";
        //         $activado_bloque=0; //SI deja imprimir
        //         $mensaje="Totem Habilitado";
        //    }
        //     if ($horarioFijoActivo==0 && $bloqueoDesbloqueoDirigido==3) {
        //         //echo "No Hay bloqueo fijo";
        //         $activado_bloque=0; //SI deja imprimir
        //         $mensaje="Totem Habilitado";
        //    }
          // echo $horarioFijoActivo."  ".$bloqueoDesbloqueoDirigido."<br>";

           //echo "MSJ:".$mensaje." DEJA INSERTAR:".$activado_bloque;

           

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



        Session::flash('message','Bloqueo Horario Fijo HoraInicio: ' .$eliminar_bloquehorariofijo->hora_inicio_bloq_horario. ' Hora Fin: '.$eliminar_bloquehorariofijo->hora_fin_bloq_horario.' Eliminado  correctamente');
         return redirect()->route('BloqueoHorarioFijo.index');
    }
}
