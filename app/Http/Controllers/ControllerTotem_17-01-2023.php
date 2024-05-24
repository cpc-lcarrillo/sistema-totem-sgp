<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection as Collection;
use DB;
use Session;
use SoapClient;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;

class ControllerTotem extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return view('usuarios.index', compact('listausuarios'));

        return view('totem');
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
        //    $request->validate([
        //     'title' => 'bail|required|unique:posts|max:255',
        //     'body' => 'required',
        // ]);
        if ($request->folio == '' and $request->patente == '') {
            Session::flash('folio', ' El campo Folio está vacio.');
            Session::flash('patente', ' El campo Patente está vacio.');
            return redirect()->back();
        }

        $patente = $request->patente;
        $folio = $request->folio;
        $parametros = [
            'user' => 'tecap.ws',
            'password' => 'ws.tecap',
            'patente' => $request->patente,
            'folio' => $request->folio,
        ];
        $ch = curl_init('127.0.0.1/ws2/cliente.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parametros));

        $response = curl_exec($ch);
        curl_close($ch);

        if ($response == 'null') {
            Session::flash('patente', ' La Patente o Folio no esta agendada.');

            return redirect()->back();
        }

        if (!$response) {
            //return false;
            $collection = '';
            return view('imprimir', compact('collection', 'patente', 'folio'));
        } else {
            //dd(json_decode($response));
            $collection = Collection::make(json_decode($response));
            //dd($collection) ;

            //echo $response;

            //return $response;
            return view('imprimir', compact('collection', 'patente', 'folio'));
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
        // $data = DB::connection('mysql')->select('CALL sp_validar_re_imprimir_ticket('.$id.')');



        // return $data[0]->nombre;
        //return $ValidacionRe_Imprimir;

        $folio = $id;
        $parametros = [
            'user' => 'tecap.ws',
            'password' => 'ws.tecap',
            'folio' => $folio,
        ];
        $ch = curl_init('127.0.0.1/ws2/cliente.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parametros));

        $response = curl_exec($ch);
        curl_close($ch);
        if (!$response) {
            //return false;
            $collection = '';
            return view('imprimir', compact('collection', 'patente', 'folio'));
        } else {
            //dd(json_decode($response));
            //return $response;
            $collection = Collection::make(json_decode($response));
            //return $collection;
            $ValidacionRe_Imprimir = DB::connection('mysql')->select('CALL sp_validar_re_imprimir_ticket(' . $id . ')');
            //return $ValidacionRe_Imprimir;
            //////////////AQUI VA LA VALIDACION SI SE ASIGNA ATENCION O SE RE-IMPRIME
            if (empty($ValidacionRe_Imprimir[0]->id_estado)) {
                $idESTADORegistroAGEN = '0';
                //return "viene vacio".$idESTADORegistroAGEN;
            } else {
                $idESTADORegistroAGEN = $ValidacionRe_Imprimir[0]->id_estado;
                //return "NO viene vacio".$idESTADORegistroAGEN;

            }
            //return $collection;
            //return $idESTADORegistroAGEN;
            switch ($idESTADORegistroAGEN) {
                case '0':
                    // ASIGNA NUMERO DE ATENCION POR QUE TIENE ESTADO 0 que signica que no ha ingresado.
                    foreach ($collection as $valor) {


                        if ($valor->REFEERS == "N") {
                            $tipodecontenedor = "Dry";
                        } else {
                            $tipodecontenedor = "Refeer";
                        }
                        $hora_actual = date("H:i");
                        //$hora_actual = date("11:11");
                        //return $hora_actual;
                        $ListaDelays = DB::table('DelayIngreso')->first();
                        //return $ListaDelays->Delay_Inicio;
                        
                         $hora_agendada_inicio = date("H:i", strtotime($valor->HORAINICIO . "- ".$ListaDelays->Delay_Inicio." minute"));
                         $hora_agendada_fin = date("H:i", strtotime($valor->HORAFIN . "+ ".$ListaDelays->Delay_Fin." minute"));


                        //return $tipodecontenedor ; //Entrega de Contenedor Full id 3

                        $conteo = DB::table('mision')
             ->select(DB::raw('count(mision.nombre) as conteo'))            
             ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)                   
             ->get();    
             $validacion = DB::table('mision')
             ->select('tipo_contenedor', 'horario')
             ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)                   
             ->get();    

             //return $conteo;
             
                            /// Valido si la mision tiene mas de una opcion y si el tipo de contenedor es vacio y el horario es vacio
                            //return $conteo[0]->conteo;
                            if($conteo[0]->conteo == 1){
                                    //return "es 1";
                                    if (empty($validacion[0]->tipo_contenedor)) {
                                        //return 'tipo_contenedor es vacio';
                                        $tipodecontenedor="";    
                                        
                                        //return "Contenedor:".$tipodecontenedor."Horario:".$horario;
                                       
                                            
                                    }
                                    if(empty($validacion[0]->horario)){
                                        //return "horario es vacio".$validacion[0]->horario;
                                       $horario=0;
                                   }else{
                                       $horario=1;
                                   }

                                   if($tipodecontenedor=="" && $horario == 0 ){
                                    $misionFinal = DB::table('mision')
                                    ->select('mision.nombre')
                                    ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)
                                    ->first();

                                    //return $misionFinal->nombre;
                                }else{
                                    //return "mision con horario";
                                    $misionFinal = DB::table('mision')
                                    ->select('mision.nombre')
                                    ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)
                                    ->where('mision.horario', '=', $validacion[0]->horario)
                                    ->first();

                                    //return $misionFinal->nombre;  
                                }
                                   //// ultimo
                                    
                            }else{
                                
                                //return $valor->NUMEROMISION;
                                
                                

                                if ($hora_actual >= $hora_agendada_inicio && $hora_actual <= $hora_agendada_fin) {
                                    ///return "Dentro del bloque";
                                    $horario="Bloque";
                                }else {
                                    //validar si llego antes del horario
                                    if ($hora_actual <= $hora_agendada_inicio) {
                                        ///return "llego antes de la hora Agendada";
                                        $horario="Fuera";
                                    }
                                    if ($hora_actual >= $hora_agendada_fin) {
                                        //return "llego despues de la hora agendada";
                                        $horario="Fuera";
                                    }
                                }
                                //return $valor->NUMEROMISION;
                                        //valido la mision si es 2,4,0 quiere decir que no tienen bloque
                                    if($valor->NUMEROMISION == 2 or 4 or 0){
                                        
                                        $tipocontenedordb= DB::table('mision')
                                    ->select('mision.nombre','mision.horario','mision.tipo_contenedor')
                                    ->where('mision.mision_puerto', '=', $valor->NUMEROMISION) 
                                    ->where('mision.tipo_contenedor', '=', $tipodecontenedor)                                                                      
                                    ->first();
                                    //return $tipocontenedordb;
                                    }else{
                                        
                                        $tipocontenedordb= DB::table('mision')
                                    ->select('mision.nombre','mision.horario','mision.tipo_contenedor')
                                    ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)
                                    ->where('mision.horario', '=', $horario)
                                    ->first();
                                    }
                                //return $valor->NUMEROMISION.$horario.$tipodecontenedor;
                                    // $tipocontenedordb= DB::table('mision')
                                    // ->select('mision.nombre','mision.horario','mision.tipo_contenedor')
                                    // ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)
                                    // ->where('mision.horario', '=', $horario)
                                    // ->first();


                                    //return $tipocontenedordb->tipo_contenedor;
                                    //return $tipocontenedordb->nombre."---".$tipocontenedordb->horario."---".$tipocontenedordb->tipo_contenedor;
                                //return $tipocontenedordb;
                                    if(empty($tipocontenedordb->tipo_contenedor)){
                                        //return "vacio".$horario.$valor->NUMEROMISION;
                                        $misionFinal = DB::table('mision')
                                    ->select('mision.nombre')
                                    ->where([
                                        ['mision.horario', '=', $horario],
                                        ['mision.mision_puerto', '=', $valor->NUMEROMISION]
                                        
                                
                                    ])                                    
                                    ->first();
                                    //return $misionFinal->nombre;
                                    }else{
                                        //return $horario;
                                        $misionFinal = DB::table('mision')
                                    ->select('mision.nombre')
                                    ->where([
                                        ['mision.mision_puerto', '=', $valor->NUMEROMISION],
                                        ['mision.tipo_contenedor', '=', $tipodecontenedor]
                                        
                                
                                    ])                                    
                                    ->first();

                                    //return $misionFinal->nombre;
                                    }

                                
                                //return "es mayor a 1";
                            }

                        



                        $data = [
                            'patente' => $valor->PATENTE,
                            'mision' => $misionFinal->nombre,
                            'id_empresa' => '1',
                            'folio' => $folio,
                        ];
                        //return $data;
                        $ch = curl_init('127.0.0.1:5001/asignar_numero_atencion');
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

                        $response2 = curl_exec($ch);
                        curl_close($ch);
                        if (!$response2) {
                            return false;
                        } else {
                            //    $responses = str_replace(array('[', ']'), '', htmlspecialchars(json_encode($response), ENT_NOQUOTES));
                            //    $response = json_decode($responses,true) ;

                            // $Numero = substr($response, 21, 4);

                            $collection2 = Collection::make(json_decode($response2));

                            //return $collection2;
                            ///webservice ejecutarWSPuerto

                            foreach ($collection2 as $coleccion2) {
                                $numeroAtencion = $coleccion2[0]->numero_atencion;
                                $uniqueid = $coleccion2[0]->uniqueid;
                            }

                            foreach ($collection as $coleccion) {
                                $PATENTE = $coleccion->PATENTE;
                                $IDENTIFICADOR = $coleccion->IDENTIFICADOR;
                            }

                            date_default_timezone_set('America/Santiago');
                            echo $hoy = date('d/m/Y g:ia');
                            $fechatiempo = date('Y-m-d H:i:s');

                            $data = [
                                'uniqueid' => @$uniqueid,
                                'patente' => $PATENTE,
                                'fechatiempo' => $fechatiempo,
                                'ubicacion' => '11',
                                'folio' => $IDENTIFICADOR,
                                'guid' => '',
                            ];
                            $ch = curl_init('127.0.0.1:5001/ejecutarWSPuerto');
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

                            $response2 = curl_exec($ch);
                            curl_close($ch);
                            if (!$response2) {
                                return false;
                            } else {
                                //$collection2 = Collection::make(json_decode($response2));
                                //return $collection2;
                            }
                            ///webservice ejecutarWSPuerto
                            //return $collection2;
                            return view('show', compact('collection', 'collection2'));

                            //return view('show', compact('Numero','collection'));
                        }
                    }

                    // AQUI FINALIZA EL IF DE VALIDACION
                    break;



                case '3':

                    // ASIGNA NUMERO DE ATENCION POR QUE TIENE ESTADO 3 o 5
                    foreach ($collection as $valor) {
                        
                        if ($valor->REFEERS == "N") {
                            $tipodecontenedor = "Dry";
                        } else {
                            $tipodecontenedor = "Refeer";
                        }
                        $hora_actual = date("H:i");
                        //$hora_actual = date("11:11");
                        //return $hora_actual." VALOR ES 3 por que el estado_registro es FInalizado";
                        
                        $ListaDelays = DB::table('DelayIngreso')->first();
                        //return $ListaDelays->Delay_Inicio;
                        
                         $hora_agendada_inicio = date("H:i", strtotime($valor->HORAINICIO . "- ".$ListaDelays->Delay_Inicio." minute"));
                         $hora_agendada_fin = date("H:i", strtotime($valor->HORAFIN . "+ ".$ListaDelays->Delay_Fin." minute"));

                        //return $tipodecontenedor ; //Entrega de Contenedor Full id 3

                        $conteo = DB::table('mision')
             ->select(DB::raw('count(mision.nombre) as conteo'))            
             ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)                   
             ->get();    
             $validacion = DB::table('mision')
             ->select('tipo_contenedor', 'horario')
             ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)                   
             ->get();    

             //return $conteo."VALIDACION".$validacion;
             
                            /// Valido si la mision tiene mas de una opcion y si el tipo de contenedor es vacio y el horario es vacio
                            //return $conteo[0]->conteo;
                            if($conteo[0]->conteo == 1){
                                    //return "es 1";
                                    if (empty($validacion[0]->tipo_contenedor)) {
                                        //return 'tipo_contenedor es vacio';
                                        $tipodecontenedor="";    
                                        
                                        //return "Contenedor:".$tipodecontenedor."Horario:".$horario;
                                       
                                            
                                    }
                                    if(empty($validacion[0]->horario)){
                                        //return "horario es vacio".$validacion[0]->horario;
                                       $horario=0;
                                   }else{
                                       $horario=1;
                                   }

                                   if($tipodecontenedor=="" && $horario == 0 ){
                                    $misionFinal = DB::table('mision')
                                    ->select('mision.nombre')
                                    ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)
                                    ->first();

                                    //return $misionFinal->nombre;
                                }else{
                                    //return "mision con horario";
                                    $misionFinal = DB::table('mision')
                                    ->select('mision.nombre')
                                    ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)
                                    ->where('mision.horario', '=', $validacion[0]->horario)
                                    ->first();

                                    //return $misionFinal->nombre;  
                                }
                                   //// ultimo
                                    
                            }else{                                
                                        //return $valor->NUMEROMISION;

                                if ($hora_actual >= $hora_agendada_inicio && $hora_actual <= $hora_agendada_fin) {
                                    ///return "Dentro del bloque";
                                    $horario="Bloque";
                                }else {
                                    //validar si llego antes del horario
                                    if ($hora_actual <= $hora_agendada_inicio) {
                                        ///return "llego antes de la hora Agendada";
                                        $horario="Fuera";
                                    }
                                    if ($hora_actual >= $hora_agendada_fin) {
                                        //return "llego despues de la hora agendada";
                                        $horario="Fuera";
                                    }
                                }

                                //return $horario;
                                    if($valor->NUMEROMISION == 3){
                                        $tipocontenedordb= DB::table('mision')
                                        ->select('mision.nombre','mision.horario','mision.tipo_contenedor')
                                        ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)
                                        ->where('mision.horario', '=', $horario)
                                        ->first(); 
                                    }else{
                                        $tipocontenedordb= DB::table('mision')
                                    ->select('mision.nombre','mision.horario','mision.tipo_contenedor')
                                    ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)
                                    ->where('mision.tipo_contenedor', '=', $tipodecontenedor)
                                    ->first();
                                    }


                                    // $tipocontenedordb= DB::table('mision')
                                    // ->select('mision.nombre','mision.horario','mision.tipo_contenedor')
                                    // ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)
                                    // ->where('mision.horario', '=', $horario)
                                    // ->first();
                                   
                                    //return $tipocontenedordb->nombre."---".$tipocontenedordb->horario."---".$tipocontenedordb->tipo_contenedor;
                                    //return $valor->NUMEROMISION.$tipocontenedordb->tipo_contenedor;
                                    

                                    if(empty($tipocontenedordb->tipo_contenedor)){
                                       // return "vacio";
                                        $misionFinal = DB::table('mision')
                                    ->select('mision.nombre')
                                    ->where([
                                        ['mision.horario', '=', $horario],
                                        ['mision.mision_puerto', '=', $valor->NUMEROMISION],
                                        // ['mision.tipo_contenedor', '=', $tipodecontenedor]
                                
                                    ])                                    
                                    ->first();
                                    //return $misionFinal->nombre."  -----tipocontenedordb es vacio";
                                    }else{
                                        $misionFinal = DB::table('mision')
                                    ->select('mision.nombre')
                                    ->where([
                                        // ['mision.horario', '=', $horario],
                                        ['mision.mision_puerto', '=', $valor->NUMEROMISION],
                                        ['mision.tipo_contenedor', '=', $tipodecontenedor]
                                
                                    ])                                    
                                    ->first();
                                    //return $misionFinal->nombre."    ---tipocontenedordb NO es vacio";
                                    //return $horario;
                                    }

                                
                                //return "es mayor a 1";
                            }
                                //return $misionFinal;
                        $data = [
                            'patente' => $valor->PATENTE,
                            'mision' => $misionFinal->nombre,
                            'id_empresa' => '1',
                            'folio' => $folio,
                        ];

                        $ch = curl_init('127.0.0.1:5001/asignar_numero_atencion');
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

                        $response2 = curl_exec($ch);
                        curl_close($ch);
                        if (!$response2) {
                            return false;
                        } else {
                            //    $responses = str_replace(array('[', ']'), '', htmlspecialchars(json_encode($response), ENT_NOQUOTES));
                            //    $response = json_decode($responses,true) ;

                            // $Numero = substr($response, 21, 4);

                            $collection2 = Collection::make(json_decode($response2));

                            ///webservice ejecutarWSPuerto

                            foreach ($collection2 as $coleccion2) {
                                $numeroAtencion = $coleccion2[0]->numero_atencion;
                                $uniqueid = $coleccion2[0]->uniqueid;
                            }

                            foreach ($collection as $coleccion) {
                                $PATENTE = $coleccion->PATENTE;
                                $IDENTIFICADOR = $coleccion->IDENTIFICADOR;
                            }

                            date_default_timezone_set('America/Santiago');
                            echo $hoy = date('d/m/Y g:ia');
                            $fechatiempo = date('Y-m-d H:i:s');

                            $data = [
                                'uniqueid' => @$uniqueid,
                                'patente' => $PATENTE,
                                'fechatiempo' => $fechatiempo,
                                'ubicacion' => '11',
                                'folio' => $IDENTIFICADOR,
                                'guid' => '',
                            ];
                            $ch = curl_init('127.0.0.1:5001/ejecutarWSPuerto');
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

                            $response2 = curl_exec($ch);
                            curl_close($ch);
                            if (!$response2) {
                                return false;
                            } else {
                                //$collection2 = Collection::make(json_decode($response2));
                                //return $collection2;
                            }
                            ///webservice ejecutarWSPuerto
                            //return $collection2;
                            return view('show', compact('collection', 'collection2'));

                            //return view('show', compact('Numero','collection'));
                        }
                    }

                    // AQUI FINALIZA EL IF DE VALIDACION
                    break;



                case '5':
                    // ASIGNA NUMERO DE ATENCION POR QUE TIENE ESTADO 3 o 5
                    foreach ($collection as $valor) {
                        
                        if ($valor->REFEERS == "N") {
                            $tipodecontenedor = "Dry";
                        } else {
                            $tipodecontenedor = "Refeer";
                        }
                        $hora_actual = date("H:i");
                        //$hora_actual = date("11:11");
                        //return $hora_actual." VALOR ES 5 por que el estado_registro es No se presento";
                        $ListaDelays = DB::table('DelayIngreso')->first();
                        //return $ListaDelays->Delay_Inicio;
                        
                         $hora_agendada_inicio = date("H:i", strtotime($valor->HORAINICIO . "- ".$ListaDelays->Delay_Inicio." minute"));
                         $hora_agendada_fin = date("H:i", strtotime($valor->HORAFIN . "+ ".$ListaDelays->Delay_Fin." minute"));
                        


                        //return $tipodecontenedor ; //Entrega de Contenedor Full id 3

                        $conteo = DB::table('mision')
             ->select(DB::raw('count(mision.nombre) as conteo'))            
             ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)                   
             ->get();    
             $validacion = DB::table('mision')
             ->select('tipo_contenedor', 'horario')
             ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)                   
             ->get();    

            // return $validacion;
             
                            /// Valido si la mision tiene mas de una opcion y si el tipo de contenedor es vacio y el horario es vacio
                            //return $conteo[0]->conteo;
                            if($conteo[0]->conteo == 1){
                                    //return "es 1";
                                    if (empty($validacion[0]->tipo_contenedor)) {
                                        //return 'tipo_contenedor es vacio';
                                        $tipodecontenedor="";    
                                        
                                        //return "Contenedor:".$tipodecontenedor."Horario:".$horario;
                                       
                                            
                                    }
                                    if(empty($validacion[0]->horario)){
                                        //return "horario es vacio".$validacion[0]->horario;
                                       $horario=0;
                                   }else{
                                       $horario=1;
                                   }

                                   if($tipodecontenedor=="" && $horario == 0 ){
                                    $misionFinal = DB::table('mision')
                                    ->select('mision.nombre')
                                    ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)
                                    ->first();

                                    //return $misionFinal->nombre;
                                }else{
                                    //return "mision con horario";
                                    $misionFinal = DB::table('mision')
                                    ->select('mision.nombre')
                                    ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)
                                    ->where('mision.horario', '=', $validacion[0]->horario)
                                    ->first();

                                    //return $misionFinal->nombre;  
                                }
                                   //// ultimo
                                    
                            }else{
                                
                                //return $valor->NUMEROMISION;
                                
                                

                                if ($hora_actual >= $hora_agendada_inicio && $hora_actual <= $hora_agendada_fin) {
                                    ///return "Dentro del bloque";
                                    $horario="Bloque";
                                }else {
                                    //validar si llego antes del horario
                                    if ($hora_actual <= $hora_agendada_inicio) {
                                        ///return "llego antes de la hora Agendada";
                                        $horario="Fuera";
                                    }
                                    if ($hora_actual >= $hora_agendada_fin) {
                                        //return "llego despues de la hora agendada";
                                        $horario="Fuera";
                                    }
                                }

                                if($valor->NUMEROMISION == 3){
                                    $tipocontenedordb= DB::table('mision')
                                    ->select('mision.nombre','mision.horario','mision.tipo_contenedor')
                                    ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)
                                    ->where('mision.horario', '=', $horario)
                                    ->first(); 
                                }else{
                                    $tipocontenedordb= DB::table('mision')
                                ->select('mision.nombre','mision.horario','mision.tipo_contenedor')
                                ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)
                                ->where('mision.tipo_contenedor', '=', $tipodecontenedor)
                                ->first();
                                }
                                   // $tipocontenedordb= DB::table('mision')
                                   // ->select('mision.nombre','mision.horario','mision.tipo_contenedor')
                                   // ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)
                                   // ->where('mision.horario', '=', $horario)
                                   // ->first();

                                    //return $tipocontenedordb->nombre."---".$tipocontenedordb->horario."---".$tipocontenedordb->tipo_contenedor;

                                    if(empty($tipocontenedordb->tipo_contenedor)){
                                        // return "vacio";
                                         $misionFinal = DB::table('mision')
                                     ->select('mision.nombre')
                                     ->where([
                                         ['mision.horario', '=', $horario],
                                         ['mision.mision_puerto', '=', $valor->NUMEROMISION],
                                         // ['mision.tipo_contenedor', '=', $tipodecontenedor]
                                 
                                     ])                                    
                                     ->first();
                                     //return $misionFinal->nombre."  -----tipocontenedordb es vacio";
                                     }else{
                                         $misionFinal = DB::table('mision')
                                     ->select('mision.nombre')
                                     ->where([
                                         // ['mision.horario', '=', $horario],
                                         ['mision.mision_puerto', '=', $valor->NUMEROMISION],
                                         ['mision.tipo_contenedor', '=', $tipodecontenedor]
                                 
                                     ])                                    
                                     ->first();
                                     //return $misionFinal->nombre."    ---tipocontenedordb NO es vacio";
                                     //return $horario;
                                     }

                                
                                //return "es mayor a 1";
                            }

                        $data = [
                            'patente' => $valor->PATENTE,
                            'mision' => $misionFinal->nombre,
                            'id_empresa' => '1',
                            'folio' => $folio,
                        ];

                        $ch = curl_init('127.0.0.1:5001/asignar_numero_atencion');
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

                        $response2 = curl_exec($ch);
                        curl_close($ch);
                        if (!$response2) {
                            return false;
                        } else {
                            //    $responses = str_replace(array('[', ']'), '', htmlspecialchars(json_encode($response), ENT_NOQUOTES));
                            //    $response = json_decode($responses,true) ;

                            // $Numero = substr($response, 21, 4);

                            $collection2 = Collection::make(json_decode($response2));

                            ///webservice ejecutarWSPuerto

                            foreach ($collection2 as $coleccion2) {
                                $numeroAtencion = $coleccion2[0]->numero_atencion;
                                $uniqueid = $coleccion2[0]->uniqueid;
                            }

                            foreach ($collection as $coleccion) {
                                $PATENTE = $coleccion->PATENTE;
                                $IDENTIFICADOR = $coleccion->IDENTIFICADOR;
                            }

                            date_default_timezone_set('America/Santiago');
                            echo $hoy = date('d/m/Y g:ia');
                            $fechatiempo = date('Y-m-d H:i:s');

                            $data = [
                                'uniqueid' => @$uniqueid,
                                'patente' => $PATENTE,
                                'fechatiempo' => $fechatiempo,
                                'ubicacion' => '11',
                                'folio' => $IDENTIFICADOR,
                                'guid' => '',
                            ];
                            $ch = curl_init('127.0.0.1:5001/ejecutarWSPuerto');
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

                            $response2 = curl_exec($ch);
                            curl_close($ch);
                            if (!$response2) {
                                return false;
                            } else {
                                //$collection2 = Collection::make(json_decode($response2));
                                //return $collection2;
                            }
                            ///webservice ejecutarWSPuerto
                            //return $collection2;
                            return view('show', compact('collection', 'collection2'));

                            //return view('show', compact('Numero','collection'));
                        }
                    }

                    // AQUI FINALIZA EL IF DE VALIDACION
                    break;

                default:
                    //RE-IMPRIME EL TICKET
                    ////// return $ValidacionRe_Imprimir[0]->id_estado."NO asigna numero";
                    //return $ValidacionRe_Imprimir;
                    return view('reImprime', compact('collection', 'ValidacionRe_Imprimir'));
                    break;
            }

            //dd($collection) ;
            //dd($collection2) ;
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
        
        
        $patente = $request->patente;

        $request->validate([
            'patente' => 'required|min:6|max:15',
        ]);
        //return $request->patente;
        // if ($request->patente == '') {
        //     Session::flash('patente', ' El campo Patente está vacio.');
        //     return redirect()->back();
        // }

        //return $request->patente;
        ////aqui parte validacion del if

        $patente = "'" . $request->patente . "'";
        $mision = "'" . $request->mision . "'";

        //$ValidacionRe_Imprimir = DB::connection('mysql')->select('CALL sp_validar_no_agendados_re_imprimir_ticket(238727)');

        $ValidacionNoAgenRe_Imprimir = DB::connection('mysql')->select('CALL sp_validar_no_agendados_re_imprimir_ticket(' . $patente . ',' . $mision . ')');

        //return $ValidacionNoAgenRe_Imprimir;
        //return $ValidacionNoAgenRe_Imprimir[0]->id_estado;
        if (empty($ValidacionNoAgenRe_Imprimir)) {
            $idESTADORegistro = '0';
            //return "VACIO ".$idESTADORegistro;
        } else {
            //return "NO viene vacio";
            $idESTADORegistro = $ValidacionNoAgenRe_Imprimir[0]->id_estado;
        }

        //return $idESTADORegistro;
        switch ($idESTADORegistro) {
            case '0':
                $data = [
                    'patente' => $request->patente,
                    'mision' => $request->mision,
                    'id_empresa' => $id,
                    'folio' => '',
                ];

                $ch = curl_init('127.0.0.1:5001/asignar_numero_atencion');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

                $response = curl_exec($ch);
                curl_close($ch);
                if (!$response) {
                    return false;
                } else {
                    //$array = json_decode($response, true);
                    //return view('imprimir', compact('response'));
                    //    $responses = str_replace(array('[', ']'), '', htmlspecialchars(json_encode($response), ENT_NOQUOTES));
                    //    $response = json_decode($responses,true) ;

                    // $Numero = substr($response, 21, 4);

                    $collection2 = Collection::make(json_decode($response));

                    //return $collection2;

                    //return $collection2;

                    ///webservice ejecutarWSPuerto

                    foreach ($collection2 as $coleccion2) {
                        $numeroAtencion = $coleccion2[0]->numero_atencion;
                        $uniqueids = $coleccion2[0]->uniqueid;

                        
                    }

                    date_default_timezone_set('America/Santiago');
                    echo $hoy = date('d/m/Y g:ia');
                    $fechatiempo = date('Y-m-d H:i:s');

                    $data = [
                        'uniqueid' => @$uniqueids,
                        'patente' => $request->patente,
                        'fechatiempo' => $fechatiempo,
                        'ubicacion' => '11',
                        'folio' => '',
                        'guid' => '',
                    ];

        //SE COMENTA POR QUE NO SE AGENDAN EN WEBSERVICE DE PUERTO CORONEL
                    // return $data;
                    $ch = curl_init('127.0.0.1:5001/ejecutarWSPuerto');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

                    $response2 = curl_exec($ch);
                    curl_close($ch);
                    if (!$response2) {
                        return false;
                    } else {
                        //$collection2 = Collection::make(json_decode($response2));
                        //return $collection2;
                    }
       //SE COMENTA POR QUE NO SE AGENDAN EN WEBSERVICE DE PUERTO CORONEL             
                    ///webservice ejecutarWSPuerto
                    $patente = $request->patente;
                    ///return $collection2;
                    return view('imprimir2', compact('collection2', 'patente'));
                    //return view('imprimir2', compact('collection2'));

                    //return view('imprimir', compact('Numero'));
                }
                break;
                //ESTADO 3 FINALIZADO
            case '3':
                $data = [
                    'patente' => $request->patente,
                    'mision' => $request->mision,
                    'id_empresa' => $id,
                    'folio' => '',
                ];

                $ch = curl_init('127.0.0.1:5001/asignar_numero_atencion');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

                $response = curl_exec($ch);
                curl_close($ch);
                if (!$response) {
                    return false;
                } else {
                    //$array = json_decode($response, true);
                    //return view('imprimir', compact('response'));
                    //    $responses = str_replace(array('[', ']'), '', htmlspecialchars(json_encode($response), ENT_NOQUOTES));
                    //    $response = json_decode($responses,true) ;

                    // $Numero = substr($response, 21, 4);

                    $collection2 = Collection::make(json_decode($response));

                    //return $collection2;

                    //return $collection2;

                    ///webservice ejecutarWSPuerto

                    foreach ($collection2 as $coleccion2) {
                        $numeroAtencion = $coleccion2[0]->numero_atencion;
                        $uniqueids = $coleccion2[0]->uniqueid;
                    }

                    date_default_timezone_set('America/Santiago');
                    echo $hoy = date('d/m/Y g:ia');
                    $fechatiempo = date('Y-m-d H:i:s');

                    $data = [
                        'uniqueid' => @$uniqueids,
                        'patente' => $request->patente,
                        'fechatiempo' => $fechatiempo,
                        'ubicacion' => '11',
                        'folio' => '',
                        'guid' => '',
                    ];
         //SE COMENTA POR QUE NO SE AGENDAN EN WEBSERVICE DE PUERTO CORONEL
                    $ch = curl_init('127.0.0.1:5001/ejecutarWSPuerto');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

                    $response2 = curl_exec($ch);
                    curl_close($ch);
                    if (!$response2) {
                        return false;
                    } else {
                        //$collection2 = Collection::make(json_decode($response2));
                        //return $collection2;
                    }
        //SE COMENTA POR QUE NO SE AGENDAN EN WEBSERVICE DE PUERTO CORONEL            
                    ///webservice ejecutarWSPuerto
                    $patente = $request->patente;
                    return view('imprimir2', compact('collection2', 'patente'));
                    //return view('imprimir2', compact('collection2'));

                    //return view('imprimir', compact('Numero'));
                }
                break;

                //ESTADO NO SE PRESENTO
            case '5':
                $data = [
                    'patente' => $request->patente,
                    'mision' => $request->mision,
                    'id_empresa' => $id,
                    'folio' => '',
                ];

                $ch = curl_init('127.0.0.1:5001/asignar_numero_atencion');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

                $response = curl_exec($ch);
                curl_close($ch);
                if (!$response) {
                    return false;
                } else {
                    //$array = json_decode($response, true);
                    //return view('imprimir', compact('response'));
                    //    $responses = str_replace(array('[', ']'), '', htmlspecialchars(json_encode($response), ENT_NOQUOTES));
                    //    $response = json_decode($responses,true) ;

                    // $Numero = substr($response, 21, 4);

                    $collection2 = Collection::make(json_decode($response));

                    //return $collection2;

                    //return $collection2;

                    ///webservice ejecutarWSPuerto

                    foreach ($collection2 as $coleccion2) {
                        $numeroAtencion = $coleccion2[0]->numero_atencion;
                        $uniqueids = $coleccion2[0]->uniqueid;
                    }

                    date_default_timezone_set('America/Santiago');
                    echo $hoy = date('d/m/Y g:ia');
                    $fechatiempo = date('Y-m-d H:i:s');

                    $data = [
                        'uniqueid' => @$uniqueids,
                        'patente' => $request->patente,
                        'fechatiempo' => $fechatiempo,
                        'ubicacion' => '11',
                        'folio' => '',
                        'guid' => '',
                    ];
        //SE COMENTA POR QUE NO SE AGENDAN EN WEBSERVICE DE PUERTO CORONEL            
                    $ch = curl_init('127.0.0.1:5001/ejecutarWSPuerto');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

                    $response2 = curl_exec($ch);
                    curl_close($ch);
                    if (!$response2) {
                        return false;
                    } else {
                        //$collection2 = Collection::make(json_decode($response2));
                        //return $collection2;
                    }
        // SE COMENTA POR QUE NO SE AGENDAN EN WEBSERVICE DE PUERTO CORONEL           
                    ///webservice ejecutarWSPuerto
                    $patente = $request->patente;
                    return view('imprimir2', compact('collection2', 'patente'));
                    //return view('imprimir2', compact('collection2'));

                    //return view('imprimir', compact('Numero'));
                }
                break;
            default:
                //return "re-imprime";
                $patente = $request->patente;
                return view('reImprimir2', compact('ValidacionNoAgenRe_Imprimir', 'patente'));

                break;
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

    public function ajaxRequestPostPantalla()
    {
        $data = DB::connection('mysql')->select('CALL pantalla_informativa(1)');

        return $data;
    }

    public function ajaxRequestPostPantallahistorico()
    {
        $data = DB::connection('mysql')->select('CALL pantalla_informativa_historico(1)');

        return $data;
    }

    public function ajaxRequestPostPantallaultimollamado()
    {
        $data = DB::connection('mysql')->select('CALL pantalla_informativa(1)');

        return $data;
    }

    public function ajaxRequestPostDestinoCamion()
    {
        $data = DB::connection('mysql')->select('CALL pantalla_informativa_destino_camion()');

        return $data;
    }

    public function ajaxRequestPostPantallacolaespera()
    {
        $data = DB::connection('mysql')->select('CALL sp_reporte_cola_espera(1)');

        return $data;
    }
    public function ajaxRequestPostPantallacolaespera22()
    {
        $data = DB::connection('mysql')->select('CALL sp_reporte_cola_espera2(1)');

        return $data;
    }

    //////
    public function ajaxRequestPostPantalla2()
    {
        $data = DB::connection('mysql')->select('CALL pantalla_informativa_alerta(1)');

        return $data;
    }

    public function ajaxRequestPostPantallahistorico2()
    {
        $data = DB::connection('mysql')->select('CALL pantalla_informativa_historico(1)');

        return $data;
    }

    public function ajaxRequestPostPantallaultimollamado2()
    {
        $data = DB::connection('mysql')->select('CALL pantalla_informativa_alerta()');

        return $data;
    }

    public function ajaxRequestPostDestinoCamion2()
    {
        $data = DB::connection('mysql')->select('CALL pantalla_informativa_destino_camion()');

        return $data;
    }

    public function ajaxRequestPostPantallacolaespera2()
    {
        $data = DB::connection('mysql')->select('CALL sp_reporte_cola_espera(1)');

        return $data;
    }
}
