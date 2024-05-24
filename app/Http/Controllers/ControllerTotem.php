<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection as Collection;
use DB;
use PHPUnit\Framework\Constraint\IsTrue;
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
            $patente = ''; // error 20/02/2024
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

                        $hora_agendada_inicio = date("H:i", strtotime($valor->HORAINICIO . "- " . $ListaDelays->Delay_Inicio . " minute"));
                        $hora_agendada_fin = date("H:i", strtotime($valor->HORAFIN . "+ " . $ListaDelays->Delay_Fin . " minute"));


                        //return $tipodecontenedor ; //Entrega de Contenedor Full id 3

                        $conteo = DB::table('mision')
                            ->select(DB::raw('count(mision.nombre) as conteo'))
                            ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)
                            ->where('mision.estado_mision', '=', 1)
                            ->get();
                        $validacion = DB::table('mision')
                            ->select('tipo_contenedor', 'horario')
                            ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)
                            ->where('mision.estado_mision', '=', 1)
                            ->get();

                        //return $conteo;

                        /// Valido si la mision tiene mas de una opcion y si el tipo de contenedor es vacio y el horario es vacio
                        //return $conteo[0]->conteo;
                        if ($conteo[0]->conteo == 1) {
                            //return "es 1";
                            if (empty($validacion[0]->tipo_contenedor)) {
                                //return 'tipo_contenedor es vacio';
                                $tipodecontenedor = "";

                                //return "Contenedor:".$tipodecontenedor."Horario:".$horario;


                            }
                            if (empty($validacion[0]->horario)) {
                                //return "horario es vacio".$validacion[0]->horario;
                                $horario = 0;
                            } else {
                                $horario = 1;
                            }

                            if ($tipodecontenedor == "" && $horario == 0) {
                                $misionFinal = DB::table('mision')
                                    ->select('mision.nombre')
                                    ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)
                                    ->where('mision.estado_mision', '=', 1)
                                    ->first();

                                //return $misionFinal->nombre;
                            } else {
                                //return "mision con horario";
                                $misionFinal = DB::table('mision')
                                    ->select('mision.nombre')
                                    ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)
                                    ->where('mision.horario', '=', $validacion[0]->horario)
                                    ->where('mision.estado_mision', '=', 1)
                                    ->first();

                                //return $misionFinal->nombre;  
                            }
                            //// ultimo

                        } else {

                            //return $valor->NUMEROMISION;



                            if ($hora_actual >= $hora_agendada_inicio && $hora_actual <= $hora_agendada_fin) {
                                ///return "Dentro del bloque";
                                $horario = "Bloque";
                            } else {
                                //validar si llego antes del horario
                                if ($hora_actual <= $hora_agendada_inicio) {
                                    ///return "llego antes de la hora Agendada";
                                    $horario = "Fuera";
                                }
                                if ($hora_actual >= $hora_agendada_fin) {
                                    //return "llego despues de la hora agendada";
                                    $horario = "Fuera";
                                }
                            }
                            //return $valor->NUMEROMISION;
                            //valido la mision si es 2,4,0 quiere decir que no tienen bloque
                            $tipocontenedordb = DB::table('mision')
                                ->select('mision.nombre', 'mision.horario', 'mision.tipo_contenedor')
                                ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)
                                ->where('mision.tipo_contenedor', '=', $tipodecontenedor)
                                ->where('mision.estado_mision', '=', 1)
                                ->where('mision.horario', '=', $horario)
                                ->first();
                            if (empty($tipocontenedordb)) {
                                $tipocontenedordb = DB::table('mision')
                                    ->select('mision.nombre', 'mision.horario', 'mision.tipo_contenedor')
                                    ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)
                                    ->where('mision.estado_mision', '=', 1)
                                    ->where('mision.tipo_contenedor', '=', $tipodecontenedor)
                                    ->first();
                                if (empty($tipocontenedordb)) {
                                    $tipocontenedordb = DB::table('mision')
                                        ->select('mision.nombre', 'mision.horario', 'mision.tipo_contenedor')
                                        ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)
                                        ->where('mision.horario', '=', $horario)
                                        ->where('mision.estado_mision', '=', 1)
                                        ->first();
                                }
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
                            if (empty($tipocontenedordb->tipo_contenedor)) {
                                //return "vacio".$horario.$valor->NUMEROMISION;
                                $misionFinal = DB::table('mision')
                                    ->select('mision.nombre')
                                    ->where([
                                        ['mision.horario', '=', $horario],
                                        ['mision.mision_puerto', '=', $valor->NUMEROMISION],
                                        ['mision.estado_mision', '=', 1]

                                    ])
                                    ->first();
                                //return $misionFinal->nombre;
                            } else {
                                if (empty($tipocontenedordb->horario)) {
                                    $misionFinal = DB::table('mision')
                                        ->select('mision.nombre')
                                        ->where([
                                            ['mision.mision_puerto', '=', $valor->NUMEROMISION],
                                            ['mision.tipo_contenedor', '=', $tipodecontenedor],
                                            ['mision.estado_mision', '=', 1]
                                        ])
                                        ->first();
                                } else {
                                    $misionFinal = DB::table('mision')
                                        ->select('mision.nombre')
                                        ->where([
                                            ['mision.mision_puerto', '=', $valor->NUMEROMISION],
                                            ['mision.horario', '=', $horario],
                                            ['mision.tipo_contenedor', '=', $tipodecontenedor],
                                            ['mision.estado_mision', '=', 1]
                                        ])
                                        ->first();
                                }
                                //return $horario;

                                //return $misionFinal->nombre;
                            }


                            //return "es mayor a 1";
                        }

                        $EstadoOCR = DB::table('AdminOCR')
                            ->select('estado_actividad')
                            ->first();

                        $SegundaVueltaDia = DB::connection('mysql')->select("CALL FindRegistrationsInTimeRange('$valor->PATENTE')");
                        // echo($SegundaVueltaDia);
                        if ($EstadoOCR->estado_actividad == 1 && empty($SegundaVueltaDia)) {
                            //return "HOLA estado_actividad 1";
                            // $validaControlEmisionTicket = DB::connection('mysql')->select('CALL sp_validaControlEmisionTicket('.$valor->PATENTE.')');

                            $validaControlEmisionTicket = DB::connection('mysql')->select("CALL sp_validaControlEmisionTicket('$valor->PATENTE')");
                            $sp_validaReIngresoEmisionTicket = DB::connection('mysql')->select("CALL sp_validaReIngresoEmisionTicket('$valor->PATENTE')");
                            //return $sp_validaReIngresoEmisionTicket;
                            //return $validaControlEmisionTicket;
                            if (empty($validaControlEmisionTicket)) {
                                //return "NO ENCUENTRA DATA en validaControlEmisionTicket y sp_validaReIngresoEmisionTicket";
                                ////no encuentra registros en base de datos ValidaControlEmisionTicket Procede a buscar en WS
                                $parametros = [
                                    'user' => 'tecap.ws',
                                    'password' => 'ws.tecap',
                                    'patente' => $valor->PATENTE,
                                    //'patente' => 'RT4286',
                                    //'folio' => $request->folio,
                                ];
                                $ch = curl_init('127.0.0.1/ws2/ws_ocr.php');
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parametros));

                                $responseOCR = curl_exec($ch);
                                curl_close($ch);

                                if ($responseOCR == 'null') {
                                    //Session::flash('patente', 'Acerquese a Oficina de Validaciones');        
                                    return view('error');
                                }
                                if (!$responseOCR) {
                                    //return false;
                                    $collectionOCR = '';
                                    return $collectionOCR;
                                    //return view('imprimir', compact('collection', 'patente', 'folio'));
                                } else {
                                    //dd(json_decode($response));
                                    $collectionOCR = Collection::make(json_decode($responseOCR));
                                    //dd($collectionOCR) ;

                                    //echo $response;

                                    //return $response;
                                    if ($collectionOCR[0]->EXISTEOCR == 'N') {
                                        //Session::flash('patente', 'Acerquese a Oficina de Validaciones');        
                                        //return redirect()->back();
                                        //return "Acerquese a Oficina de Validaciones";
                                        return view('error');
                                    }
                                    //return $collectionOCR;
                                    // return $collectionOCR[0]->EXISTEOCR;
                                    $fechaCompleta = $collectionOCR[0]->FECHA . " " . $collectionOCR[0]->HORA;
                                    $fechaActual = date("Y-m-d H:i:s");
                                    $horaMenos24 = date("Y-m-d H:i:s", strtotime($fechaActual . "-24 hour"));
                                    @$fechavalidacion = $sp_validaReIngresoEmisionTicket[0]->fechaEmision;
                                    if ($horaMenos24 <= $fechaCompleta) {
                                        //return "es igual o menor ".$fechaCompleta." patente".$collectionOCR[0]->PATENTE;
                                        if ($fechavalidacion != $fechaCompleta) {
                                            //return "es diferente ";
                                            DB::table('controlEmisionTicket')->insert([
                                                'fechaIngreso' => $collectionOCR[0]->FECHA,
                                                'horaIngreso' => $collectionOCR[0]->HORA,
                                                'patenteTransporte' => $collectionOCR[0]->PATENTE,
                                                'fechaEmision' => $collectionOCR[0]->FECHA . " " . $collectionOCR[0]->HORA,
                                                'statusEmision' => "N",
                                                'generacionRegistro' => "A"

                                            ]);
                                            // return view('imprimir', compact('collection', 'patente', 'folio'));
                                            /// YA SE IMPRIME


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
                                                DB::table('controlEmisionTicket')->where('patenteTransporte', $valor->PATENTE)->update([
                                                    'statusEmision' => "S"
                                                ]);
                                                return view('show', compact('collection', 'collection2'));

                                                //return view('show', compact('Numero','collection'));
                                            }
                                        } else {
                                            //return "es diferente ";
                                            return view('error');
                                        }

                                    } else {
                                        //return "NO lo es";
                                        return view('error');
                                    }

                                    /// YA SE IMPRIME
                                }
                                ////FIN
                            } else {
                                ///return "ENCUENTRA DATA en validaControlEmisionTicket y sp_validaReIngresoEmisionTicket";                
                                if (true) {
                                    //return "no encuentra data";
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
                                        DB::table('controlEmisionTicket')->where('patenteTransporte', $valor->PATENTE)->update([
                                            'statusEmision' => "S"
                                        ]);
                                        return view('show', compact('collection', 'collection2'));

                                        //return view('show', compact('Numero','collection'));
                                    } //

                                } else {
                                    return view('error');
                                }

                                //////////////////////////////////////encuentra data
                            }

                        } else {
                            ///return "HOLA estado_actividad 0";
/////////////////////////////////ESTADO DE ACTIVIDAD 0
                            $validaControlEmisionTicket = DB::connection('mysql')->select("CALL sp_validaControlEmisionTicket('$valor->PATENTE')");
                            $sp_validaReIngresoEmisionTicket = DB::connection('mysql')->select("CALL sp_validaReIngresoEmisionTicket('$valor->PATENTE')");
                            //return $sp_validaReIngresoEmisionTicket;
                            //return $validaControlEmisionTicket;
                            if (empty($validaControlEmisionTicket)) {

                                date_default_timezone_set('America/Santiago');
                                //echo $hoy = date('d/m/Y g:ia');
                                // $horaactual = date('H:i:s');                    
                                // $newDate = date('Y-m-d');
                                // DB::table('controlEmisionTicket')->insert([
                                // 'fechaIngreso'           =>    $newDate,
                                // 'horaIngreso'            =>    $horaactual,
                                // 'patenteTransporte'      =>    $valor->PATENTE,  
                                // 'statusEmision'          =>    "N",
                                // 'generacionRegistro'     =>    "A"

                                // ]);
                            } else {
                                //return "actualizo";
                                date_default_timezone_set('America/Santiago');
                                //echo $hoy = date('d/m/Y g:ia');
                                $horaactual = date('H:i:s');
                                $newDate = date('Y-m-d');
                                // DB::table('controlEmisionTicket')->where('patenteTransporte', $valor->PATENTE)->update([ 
                                // 'statusEmision'          =>    "N",
                                // 'generacionRegistro'     =>    "A"
                                // ]);
                            }
                            // return view('imprimir', compact('collection', 'patente', 'folio'));
                            /// YA SE IMPRIME


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
                                // DB::table('controlEmisionTicket')->where('patenteTransporte', $valor->PATENTE)->update([
                                //     'statusEmision'          =>    "S" 
                                // ]);


                                return view('show', compact('collection', 'collection2'));

                                //return view('show', compact('Numero','collection'));
                            }
                            /// YA SE IMPRIME

                            /////////////////////////////////ESTADO DE ACTIVIDAD 0


                        }




                    }

                    // AQUI FINALIZA EL IF DE VALIDACION
                    break;



                case '3':
                    //return "caso 3";
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

                        $hora_agendada_inicio = date("H:i", strtotime($valor->HORAINICIO . "- " . $ListaDelays->Delay_Inicio . " minute"));
                        $hora_agendada_fin = date("H:i", strtotime($valor->HORAFIN . "+ " . $ListaDelays->Delay_Fin . " minute"));

                        //return $tipodecontenedor ; //Entrega de Contenedor Full id 3

                        $conteo = DB::table('mision')
                            ->select(DB::raw('count(mision.nombre) as conteo'))
                            ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)
                            ->where('mision.estado_mision', '=', 1)
                            ->get();
                        $validacion = DB::table('mision')
                            ->select('tipo_contenedor', 'horario')
                            ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)
                            ->where('mision.estado_mision', '=', 1)
                            ->get();

                        //return $conteo."VALIDACION".$validacion;

                        /// Valido si la mision tiene mas de una opcion y si el tipo de contenedor es vacio y el horario es vacio
                        //return $conteo[0]->conteo;
                        if ($conteo[0]->conteo == 1) {
                            //return "es 1";
                            if (empty($validacion[0]->tipo_contenedor)) {
                                //return 'tipo_contenedor es vacio';
                                $tipodecontenedor = "";

                                //return "Contenedor:".$tipodecontenedor."Horario:".$horario;


                            }
                            if (empty($validacion[0]->horario)) {
                                //return "horario es vacio".$validacion[0]->horario;
                                $horario = 0;
                            } else {
                                $horario = 1;
                            }

                            if ($tipodecontenedor == "" && $horario == 0) {
                                $misionFinal = DB::table('mision')
                                    ->select('mision.nombre')
                                    ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)
                                    ->where('mision.estado_mision', '=', 1)
                                    ->first();

                                //return $misionFinal->nombre;
                            } else {
                                //return "mision con horario";
                                $misionFinal = DB::table('mision')
                                    ->select('mision.nombre')
                                    ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)
                                    ->where('mision.horario', '=', $validacion[0]->horario)
                                    ->where('mision.estado_mision', '=', 1)
                                    ->first();

                                //return $misionFinal->nombre;  
                            }
                            //// ultimo

                        } else {
                            //return $valor->NUMEROMISION;

                            if ($hora_actual >= $hora_agendada_inicio && $hora_actual <= $hora_agendada_fin) {
                                ///return "Dentro del bloque";
                                $horario = "Bloque";
                            } else {
                                //validar si llego antes del horario
                                if ($hora_actual <= $hora_agendada_inicio) {
                                    ///return "llego antes de la hora Agendada";
                                    $horario = "Fuera";
                                }
                                if ($hora_actual >= $hora_agendada_fin) {
                                    //return "llego despues de la hora agendada";
                                    $horario = "Fuera";
                                }
                            }

                            //return $horario;
                            // if ($valor->NUMEROMISION == 3) {
                            //     $tipocontenedordb = DB::table('mision')
                            //         ->select('mision.nombre', 'mision.horario', 'mision.tipo_contenedor')
                            //         ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)
                            //         ->where('mision.horario', '=', $horario)
                            //         ->where('mision.estado_mision', '=', 1)
                            //         ->first();
                            // } else {
                            //     $tipocontenedordb = DB::table('mision')
                            //         ->select('mision.nombre', 'mision.horario', 'mision.tipo_contenedor')
                            //         ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)
                            //         ->where('mision.estado_mision', '=', 1)
                            //         ->where('mision.tipo_contenedor', '=', $tipodecontenedor)
                            //         ->first();
                            // }
                            $tipocontenedordb = DB::table('mision')
                                ->select('mision.nombre', 'mision.horario', 'mision.tipo_contenedor')
                                ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)
                                ->where('mision.tipo_contenedor', '=', $tipodecontenedor)
                                ->where('mision.estado_mision', '=', 1)
                                ->where('mision.horario', '=', $horario)
                                ->first();
                            if (empty($tipocontenedordb)) {
                                $tipocontenedordb = DB::table('mision')
                                    ->select('mision.nombre', 'mision.horario', 'mision.tipo_contenedor')
                                    ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)
                                    ->where('mision.estado_mision', '=', 1)
                                    ->where('mision.tipo_contenedor', '=', $tipodecontenedor)
                                    ->first();
                                if (empty($tipocontenedordb)) {
                                    $tipocontenedordb = DB::table('mision')
                                        ->select('mision.nombre', 'mision.horario', 'mision.tipo_contenedor')
                                        ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)
                                        ->where('mision.horario', '=', $horario)
                                        ->where('mision.estado_mision', '=', 1)
                                        ->first();
                                }
                            }

                            // $tipocontenedordb= DB::table('mision')
                            // ->select('mision.nombre','mision.horario','mision.tipo_contenedor')
                            // ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)
                            // ->where('mision.horario', '=', $horario)
                            // ->first();

                            //return $tipocontenedordb->nombre."---".$tipocontenedordb->horario."---".$tipocontenedordb->tipo_contenedor;
                            //return $valor->NUMEROMISION.$tipocontenedordb->tipo_contenedor;


                            if (empty($tipocontenedordb->tipo_contenedor)) {
                                //return "vacio".$horario.$valor->NUMEROMISION;
                                $misionFinal = DB::table('mision')
                                    ->select('mision.nombre')
                                    ->where([
                                        ['mision.horario', '=', $horario],
                                        ['mision.mision_puerto', '=', $valor->NUMEROMISION],
                                        ['mision.estado_mision', '=', 1]

                                    ])
                                    ->first();
                                //return $misionFinal->nombre;
                            } else {
                                if (empty($tipocontenedordb->horario)) {
                                    $misionFinal = DB::table('mision')
                                        ->select('mision.nombre')
                                        ->where([
                                            ['mision.mision_puerto', '=', $valor->NUMEROMISION],
                                            ['mision.tipo_contenedor', '=', $tipodecontenedor],
                                            ['mision.estado_mision', '=', 1]
                                        ])
                                        ->first();
                                } else {
                                    $misionFinal = DB::table('mision')
                                        ->select('mision.nombre')
                                        ->where([
                                            ['mision.mision_puerto', '=', $valor->NUMEROMISION],
                                            ['mision.horario', '=', $horario],
                                            ['mision.tipo_contenedor', '=', $tipodecontenedor],
                                            ['mision.estado_mision', '=', 1]
                                        ])
                                        ->first();
                                }
                                //return $horario;

                                //return $misionFinal->nombre;
                            }


                            //return "es mayor a 1";
                        }
                        //return $misionFinal;
                        //return "HOLA estado 5";
                        $EstadoOCR = DB::table('AdminOCR')
                            ->select('estado_actividad')
                            ->first();



                        if ($EstadoOCR->estado_actividad == 1) {
                            // return "HOLA estado_actividad 1";
                            // $validaControlEmisionTicket = DB::connection('mysql')->select('CALL sp_validaControlEmisionTicket('.$valor->PATENTE.')');
                            $validaControlEmisionTicket = DB::connection('mysql')->select("CALL sp_validaControlEmisionTicket('$valor->PATENTE')");
                            $sp_validaReIngresoEmisionTicket = DB::connection('mysql')->select("CALL sp_validaReIngresoEmisionTicket('$valor->PATENTE')");
                            //return $sp_validaReIngresoEmisionTicket;
                            //return $validaControlEmisionTicket;
                            if (empty($validaControlEmisionTicket)) {
                                //return "NO ENCUENTRA DATA";
                                ////no encuentra registros en base de datos ValidaControlEmisionTicket Procede a buscar en WS


                                $parametros = [
                                    'user' => 'tecap.ws',
                                    'password' => 'ws.tecap',
                                    'patente' => $valor->PATENTE,
                                    //'patente' => 'RT4286',
                                    //'folio' => $request->folio,
                                ];
                                $ch = curl_init('127.0.0.1/ws2/ws_ocr.php');
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parametros));

                                $responseOCR = curl_exec($ch);
                                curl_close($ch);

                                if ($responseOCR == 'null') {
                                    //Session::flash('patente', 'Acerquese a Oficina de Validaciones');        
                                    return view('error');
                                }
                                if (!$responseOCR) {
                                    //return false;
                                    $collectionOCR = '';
                                    return $collectionOCR;
                                    //return view('imprimir', compact('collection', 'patente', 'folio'));
                                } else {
                                    //dd(json_decode($response));
                                    $collectionOCR = Collection::make(json_decode($responseOCR));
                                    //dd($collectionOCR) ;

                                    //return $response;
                                    if ($collectionOCR[0]->EXISTEOCR == 'N') {
                                        //Session::flash('patente', 'Acerquese a Oficina de Validaciones');        
                                        //return redirect()->back();
                                        //return "Acerquese a Oficina de Validaciones";
                                        return view('error');
                                    }
                                    //return $collectionOCR;

                                    ///VALIDACION Si la fecha en menor o igual 24 horas
                                    $fechaCompleta = $collectionOCR[0]->FECHA . " " . $collectionOCR[0]->HORA;
                                    $fechaActual = date("Y-m-d H:i:s");
                                    $horaMenos24 = date("Y-m-d H:i:s", strtotime($fechaActual . "-24 hour"));
                                    //return $fechaCompleta."--->".$horaMenos24;
                                    // if( $horaMenos24 <=  $fechaCompleta){
                                    //         return "fecha wsOCR es menor o igual hora actual menos -24  ".$fechaCompleta."--->".$horaMenos24;
                                    // }else{
                                    //     return "no es menor".$fechaCompleta."--->".$horaMenos24;
                                    // }

                                    @$fechavalidacion = $sp_validaReIngresoEmisionTicket[0]->fechaEmision;
                                    if ($horaMenos24 <= $fechaCompleta) {
                                        //return "es igual o menor ".$fechaCompleta." patente".$collectionOCR[0]->PATENTE;
                                        if ($fechavalidacion != $fechaCompleta) {
                                            //return "es diferente ".$fechavalidacion."****".$fechaCompleta;

                                            DB::table('controlEmisionTicket')->insert([
                                                'fechaIngreso' => $collectionOCR[0]->FECHA,
                                                'horaIngreso' => $collectionOCR[0]->HORA,
                                                'fechaEmision' => $collectionOCR[0]->FECHA . " " . $collectionOCR[0]->HORA,
                                                'patenteTransporte' => $collectionOCR[0]->PATENTE,
                                                'statusEmision' => "N",
                                                'generacionRegistro' => "A"

                                            ]);
                                            // return view('imprimir', compact('collection', 'patente', 'folio'));
                                            /// YA SE IMPRIME


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
                                                DB::table('controlEmisionTicket')->where('patenteTransporte', $valor->PATENTE)->update([
                                                    'statusEmision' => "S"
                                                ]);
                                                return view('show', compact('collection', 'collection2'));

                                                //return view('show', compact('Numero','collection'));
                                            }
                                        } else {
                                            //return "no es diferente";
                                            return view('error');
                                        }

                                    } else {
                                        //return "NO lo es";
                                        return view('error');
                                    }
                                    ///FIN VALIDACION Si la fecha en menor o igual 24 horas 

                                }
                            } else {
                                //return "ENCUENTRA DATA";  

                                if (empty($sp_validaReIngresoEmisionTicket)) {
                                    //return "no encuentra data";
                                    return view('error');

                                } else {
                                    //return "si encuentra data";
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
                                        DB::table('controlEmisionTicket')->where('patenteTransporte', $valor->PATENTE)->update([
                                            'statusEmision' => "S"
                                        ]);
                                        return view('show', compact('collection', 'collection2'));

                                        //return view('show', compact('Numero','collection'));
                                    } //

                                }

                                //////////////////////////////////////encuentra data
                            }
                        } else {
                            //return "HOLA estado_actividad 0";
                            //dd($valor);
                            //return $valor->FECHA;

                            /////////////////////////////////ESTADO DE ACTIVIDAD 0
                            $validaControlEmisionTicket = DB::connection('mysql')->select("CALL sp_validaControlEmisionTicket('$valor->PATENTE')");
                            $sp_validaReIngresoEmisionTicket = DB::connection('mysql')->select("CALL sp_validaReIngresoEmisionTicket('$valor->PATENTE')");
                            //return $sp_validaReIngresoEmisionTicket;
                            //return $validaControlEmisionTicket;
                            if (empty($validaControlEmisionTicket) && empty($sp_validaReIngresoEmisionTicket)) {
                                date_default_timezone_set('America/Santiago');
                                //echo $hoy = date('d/m/Y g:ia');
                                $horaactual = date('H:i:s');
                                $newDate = date('Y-m-d');
                                // DB::table('controlEmisionTicket')->insert([
                                // 'fechaIngreso'           =>    $newDate,
                                // 'horaIngreso'            =>    $horaactual,
                                // 'patenteTransporte'      =>    $valor->PATENTE,  
                                // 'statusEmision'          =>    "N",
                                // 'generacionRegistro'     =>    "A"

                                // ]);
                            } else {
                                //return "actualizo";
                                date_default_timezone_set('America/Santiago');
                                //echo $hoy = date('d/m/Y g:ia');
                                $horaactual = date('H:i:s');
                                $newDate = date('Y-m-d');
                                // DB::table('controlEmisionTicket')->where('patenteTransporte', $valor->PATENTE)->update([ 
                                // 'statusEmision'          =>    "N",
                                // 'generacionRegistro'     =>    "A"
                                // ]);
                            }

                            // return view('imprimir', compact('collection', 'patente', 'folio'));
                            /// YA SE IMPRIME

                            //return "registro Status N";
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
                                // DB::table('controlEmisionTicket')->where('patenteTransporte', $valor->PATENTE)->update([
                                // 'statusEmision'          =>    "S" 
                                // ]);
                                return view('show', compact('collection', 'collection2'));

                                //return view('show', compact('Numero','collection'));
                            }
                            /// YA SE IMPRIME
                        }
                        /////////////////////////////////ESTADO DE ACTIVIDAD 0







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
                        //return $hora_actual." VALOR ES 3 por que el estado_registro es FInalizado";

                        $ListaDelays = DB::table('DelayIngreso')->first();
                        //return $ListaDelays->Delay_Inicio;

                        $hora_agendada_inicio = date("H:i", strtotime($valor->HORAINICIO . "- " . $ListaDelays->Delay_Inicio . " minute"));
                        $hora_agendada_fin = date("H:i", strtotime($valor->HORAFIN . "+ " . $ListaDelays->Delay_Fin . " minute"));

                        //return $tipodecontenedor ; //Entrega de Contenedor Full id 3

                        $conteo = DB::table('mision')
                            ->select(DB::raw('count(mision.nombre) as conteo'))
                            ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)
                            ->where('mision.estado_mision', '=', 1)
                            ->get();
                        $validacion = DB::table('mision')
                            ->select('tipo_contenedor', 'horario')
                            ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)
                            ->where('mision.estado_mision', '=', 1)
                            ->get();

                        //return $conteo."VALIDACION".$validacion;

                        /// Valido si la mision tiene mas de una opcion y si el tipo de contenedor es vacio y el horario es vacio
                        //return $conteo[0]->conteo;
                        if ($conteo[0]->conteo == 1) {
                            //return "es 1";
                            if (empty($validacion[0]->tipo_contenedor)) {
                                //return 'tipo_contenedor es vacio';
                                $tipodecontenedor = "";

                                //return "Contenedor:".$tipodecontenedor."Horario:".$horario;


                            }
                            if (empty($validacion[0]->horario)) {
                                //return "horario es vacio".$validacion[0]->horario;
                                $horario = 0;
                            } else {
                                $horario = 1;
                            }

                            if ($tipodecontenedor == "" && $horario == 0) {
                                $misionFinal = DB::table('mision')
                                    ->select('mision.nombre')
                                    ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)
                                    ->where('mision.estado_mision', '=', 1)
                                    ->first();

                                //return $misionFinal->nombre;
                            } else {
                                //return "mision con horario";
                                $misionFinal = DB::table('mision')
                                    ->select('mision.nombre')
                                    ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)
                                    ->where('mision.horario', '=', $validacion[0]->horario)
                                    ->where('mision.estado_mision', '=', 1)
                                    ->first();

                                //return $misionFinal->nombre;  
                            }
                            //// ultimo

                        } else {
                            //return $valor->NUMEROMISION;

                            if ($hora_actual >= $hora_agendada_inicio && $hora_actual <= $hora_agendada_fin) {
                                ///return "Dentro del bloque";
                                $horario = "Bloque";
                            } else {
                                //validar si llego antes del horario
                                if ($hora_actual <= $hora_agendada_inicio) {
                                    ///return "llego antes de la hora Agendada";
                                    $horario = "Fuera";
                                }
                                if ($hora_actual >= $hora_agendada_fin) {
                                    //return "llego despues de la hora agendada";
                                    $horario = "Fuera";
                                }
                            }

                            //return $horario;
                            $tipocontenedordb = DB::table('mision')
                                ->select('mision.nombre', 'mision.horario', 'mision.tipo_contenedor')
                                ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)
                                ->where('mision.tipo_contenedor', '=', $tipodecontenedor)
                                ->where('mision.estado_mision', '=', 1)
                                ->where('mision.horario', '=', $horario)
                                ->first();
                            if (empty($tipocontenedordb)) {
                                $tipocontenedordb = DB::table('mision')
                                    ->select('mision.nombre', 'mision.horario', 'mision.tipo_contenedor')
                                    ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)
                                    ->where('mision.estado_mision', '=', 1)
                                    ->where('mision.tipo_contenedor', '=', $tipodecontenedor)
                                    ->first();
                                if (empty($tipocontenedordb)) {
                                    $tipocontenedordb = DB::table('mision')
                                        ->select('mision.nombre', 'mision.horario', 'mision.tipo_contenedor')
                                        ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)
                                        ->where('mision.horario', '=', $horario)
                                        ->where('mision.estado_mision', '=', 1)
                                        ->first();
                                }
                            }


                            // $tipocontenedordb= DB::table('mision')
                            // ->select('mision.nombre','mision.horario','mision.tipo_contenedor')
                            // ->where('mision.mision_puerto', '=', $valor->NUMEROMISION)
                            // ->where('mision.horario', '=', $horario)
                            // ->first();

                            //return $tipocontenedordb->nombre."---".$tipocontenedordb->horario."---".$tipocontenedordb->tipo_contenedor;
                            //return $valor->NUMEROMISION.$tipocontenedordb->tipo_contenedor;


                            if (empty($tipocontenedordb->tipo_contenedor)) {
                                //return "vacio".$horario.$valor->NUMEROMISION;
                                $misionFinal = DB::table('mision')
                                    ->select('mision.nombre')
                                    ->where([
                                        ['mision.horario', '=', $horario],
                                        ['mision.mision_puerto', '=', $valor->NUMEROMISION],
                                        ['mision.estado_mision', '=', 1]

                                    ])
                                    ->first();
                                //return $misionFinal->nombre;
                            } else {
                                if (empty($tipocontenedordb->horario)) {
                                    $misionFinal = DB::table('mision')
                                        ->select('mision.nombre')
                                        ->where([
                                            ['mision.mision_puerto', '=', $valor->NUMEROMISION],
                                            ['mision.tipo_contenedor', '=', $tipodecontenedor],
                                            ['mision.estado_mision', '=', 1]
                                        ])
                                        ->first();
                                } else {
                                    $misionFinal = DB::table('mision')
                                        ->select('mision.nombre')
                                        ->where([
                                            ['mision.mision_puerto', '=', $valor->NUMEROMISION],
                                            ['mision.horario', '=', $horario],
                                            ['mision.tipo_contenedor', '=', $tipodecontenedor],
                                            ['mision.estado_mision', '=', 1]
                                        ])
                                        ->first();
                                }
                                //return $horario;

                                //return $misionFinal->nombre;
                            }


                            //return "es mayor a 1";
                        }
                        //return $misionFinal;
                        //return "HOLA estado 5";
                        $EstadoOCR = DB::table('AdminOCR')
                            ->select('estado_actividad')
                            ->first();



                        if ($EstadoOCR->estado_actividad == 1) {
                            //return "HOLA estado_actividad 1";
                            // $validaControlEmisionTicket = DB::connection('mysql')->select('CALL sp_validaControlEmisionTicket('.$valor->PATENTE.')');
                            $validaControlEmisionTicket = DB::connection('mysql')->select("CALL sp_validaControlEmisionTicket('$valor->PATENTE')");
                            $sp_validaReIngresoEmisionTicket = DB::connection('mysql')->select("CALL sp_validaReIngresoEmisionTicket('$valor->PATENTE')");
                            //return $sp_validaReIngresoEmisionTicket;
                            //return $validaControlEmisionTicket;
                            if (empty($validaControlEmisionTicket)) {
                                //return "NO ENCUENTRA DATA";
                                ////no encuentra registros en base de datos ValidaControlEmisionTicket Procede a buscar en WS
                                $parametros = [
                                    'user' => 'tecap.ws',
                                    'password' => 'ws.tecap',
                                    'patente' => $valor->PATENTE,
                                    //'patente' => 'RT4286',
                                    //'folio' => $request->folio,
                                ];
                                $ch = curl_init('127.0.0.1/ws2/ws_ocr.php');
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parametros));

                                $responseOCR = curl_exec($ch);
                                curl_close($ch);

                                if ($responseOCR == 'null') {
                                    //Session::flash('patente', 'Acerquese a Oficina de Validaciones');        
                                    return view('error');
                                }
                                if (!$responseOCR) {
                                    //return false;
                                    $collectionOCR = '';
                                    return $collectionOCR;
                                    //return view('imprimir', compact('collection', 'patente', 'folio'));
                                } else {
                                    //dd(json_decode($response));
                                    $collectionOCR = Collection::make(json_decode($responseOCR));
                                    //dd($collection) ;

                                    //echo $response;

                                    //return $response;
                                    if ($collectionOCR[0]->EXISTEOCR == 'N') {
                                        //Session::flash('patente', 'Acerquese a Oficina de Validaciones');        
                                        //return redirect()->back();
                                        //return "Acerquese a Oficina de Validaciones";
                                        return view('error');
                                    }
                                    //return $collectionOCR;
                                    // return $collectionOCR[0]->EXISTEOCR;
                                    $fechaCompleta = $collectionOCR[0]->FECHA . " " . $collectionOCR[0]->HORA;
                                    $fechaActual = date("Y-m-d H:i:s");
                                    $horaMenos24 = date("Y-m-d H:i:s", strtotime($fechaActual . "-24 hour"));
                                    @$fechavalidacion = $sp_validaReIngresoEmisionTicket[0]->fechaEmision;
                                    if ($horaMenos24 <= $fechaCompleta) {
                                        //return "es igual o menor ".$fechaCompleta." patente".$collectionOCR[0]->PATENTE;
                                        if ($fechavalidacion != $fechaCompleta) {
                                            //return "es diferente ";
                                            //return "es igual o menor ".$fechaCompleta." patente".$collectionOCR[0]->PATENTE;
                                            DB::table('controlEmisionTicket')->insert([
                                                'fechaIngreso' => $collectionOCR[0]->FECHA,
                                                'horaIngreso' => $collectionOCR[0]->HORA,
                                                'fechaEmision' => $collectionOCR[0]->FECHA . " " . $collectionOCR[0]->HORA,
                                                'patenteTransporte' => $collectionOCR[0]->PATENTE,
                                                'statusEmision' => "N",
                                                'generacionRegistro' => "A"

                                            ]);
                                            // return view('imprimir', compact('collection', 'patente', 'folio'));
                                            /// YA SE IMPRIME


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
                                                DB::table('controlEmisionTicket')->where('patenteTransporte', $valor->PATENTE)->update([
                                                    'statusEmision' => "S"
                                                ]);
                                                return view('show', compact('collection', 'collection2'));

                                                //return view('show', compact('Numero','collection'));
                                            }
                                        } else {
                                            //return "no es diferente ";
                                            return view('error');
                                        }

                                    } else {
                                        //return "NO lo es";
                                        return view('error');
                                    }


                                }
                            } else {
                                //return "ENCUENTRA DATA";                
                                if (empty($sp_validaReIngresoEmisionTicket)) {
                                    //return "no encuentra data";
                                    return view('error');

                                } else {
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
                                        DB::table('controlEmisionTicket')->where('patenteTransporte', $valor->PATENTE)->update([
                                            'statusEmision' => "S"
                                        ]);
                                        return view('show', compact('collection', 'collection2'));

                                        //return view('show', compact('Numero','collection'));
                                    } // 
                                }

                                //////////////////////////////////////encuentra data
                            }
                        } else {
                            //return "HOLA estado_actividad 0";
                            //dd($valor);
                            //return $valor->FECHA;

                            /////////////////////////////////ESTADO DE ACTIVIDAD 0
                            $validaControlEmisionTicket = DB::connection('mysql')->select("CALL sp_validaControlEmisionTicket('$valor->PATENTE')");
                            $sp_validaReIngresoEmisionTicket = DB::connection('mysql')->select("CALL sp_validaReIngresoEmisionTicket('$valor->PATENTE')");
                            //return $sp_validaReIngresoEmisionTicket;
                            //return $validaControlEmisionTicket;
                            if (empty($validaControlEmisionTicket) && empty($sp_validaReIngresoEmisionTicket)) {
                                date_default_timezone_set('America/Santiago');
                                //echo $hoy = date('d/m/Y g:ia');
                                $horaactual = date('H:i:s');
                                $newDate = date('Y-m-d');
                                // DB::table('controlEmisionTicket')->insert([
                                // 'fechaIngreso'           =>    $newDate,
                                // 'horaIngreso'            =>    $horaactual,
                                // 'patenteTransporte'      =>    $valor->PATENTE,  
                                // 'statusEmision'          =>    "N",
                                // 'generacionRegistro'     =>    "A"

                                // ]);
                            } else {
                                //return "actualizo";
                                date_default_timezone_set('America/Santiago');
                                //echo $hoy = date('d/m/Y g:ia');
                                $horaactual = date('H:i:s');
                                $newDate = date('Y-m-d');
                                // DB::table('controlEmisionTicket')->where('patenteTransporte', $valor->PATENTE)->update([ 
                                // 'statusEmision'          =>    "N",
                                // 'generacionRegistro'     =>    "A"
                                // ]);
                            }
                            //return "primer estado";
                            // return view('imprimir', compact('collection', 'patente', 'folio'));
                            /// YA SE IMPRIME

                            //return "registro Status N";
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
                                // DB::table('controlEmisionTicket')->where('patenteTransporte', $valor->PATENTE)->update([
                                // 'statusEmision'          =>    "S" 
                                // ]);
                                return view('show', compact('collection', 'collection2'));

                                //return view('show', compact('Numero','collection'));
                            }
                            /// YA SE IMPRIME
                        }
                        /////////////////////////////////ESTADO DE ACTIVIDAD 0







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

        //return "cae AQUI";
        //return $request;

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
                //return "CASO 0";
                $EstadoOCR = DB::table('AdminOCR')
                    ->select('estado_actividad')
                    ->first();

                if ($EstadoOCR->estado_actividad == 1) {
                    //return "ESTADO DE ACTIVIDAD 1";
                    $validaControlEmisionTicket = DB::connection('mysql')->select("CALL sp_validaControlEmisionTicket('$request->patente')");
                    $sp_validaReIngresoEmisionTicket = DB::connection('mysql')->select("CALL sp_validaReIngresoEmisionTicket('$request->patente')");
                    //return $sp_validaReIngresoEmisionTicket;
                    //return $validaControlEmisionTicket;
                    if (empty($validaControlEmisionTicket)) {

                        //return "NO ENCUENTRA DATA EN BD->busca en ws -> guarda DB -> proceso de impresion";
                        $parametros = [
                            'user' => 'tecap.ws',
                            'password' => 'ws.tecap',
                            'patente' => $request->patente,
                            //'patente' => 'RT4286',
                            //'folio' => $request->folio,
                        ];
                        $ch = curl_init('127.0.0.1/ws2/ws_ocr.php');
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parametros));

                        $responseOCR = curl_exec($ch);
                        curl_close($ch);
                        //return $responseOCR;
                        if ($responseOCR == 'null') {
                            //Session::flash('patente', 'Acerquese a Oficina de Validaciones');        
                            return view('error');
                        }
                        if (!$responseOCR) {
                            //return false;
                            $collectionOCR = '';
                            return $collectionOCR;
                            //return view('imprimir', compact('collection', 'patente', 'folio'));
                        } else {
                            //dd(json_decode($response));
                            $collectionOCR = Collection::make(json_decode($responseOCR));
                            //dd($collectionOCR) ;

                            //echo $response;

                            //return $response;
                            if ($collectionOCR[0]->EXISTEOCR == 'N') {
                                //Session::flash('patente', 'Acerquese a Oficina de Validaciones');        
                                //return redirect()->back();
                                //return "Acerquese a Oficina de Validaciones";
                                return view('error'); //////Acerquese a Oficina de Validaciones
                            }
                            //return $collectionOCR;
                            // return $collectionOCR[0]->EXISTEOCR;
                            date_default_timezone_set('America/Santiago');
                            //echo $hoy = date('d/m/Y g:ia');
                            $fecha = date('Y-m-d');
                            $tiempo = date('H:i:s');

                            $fechaCompleta = $collectionOCR[0]->FECHA . " " . $collectionOCR[0]->HORA;
                            $fechaActual = date("Y-m-d H:i:s");
                            $horaMenos24 = date("Y-m-d H:i:s", strtotime($fechaActual . "-24 hour"));
                            @$fechavalidacion = $sp_validaReIngresoEmisionTicket[0]->fechaEmision;
                            if ($horaMenos24 <= $fechaCompleta) {
                                //return "es igual o menor ".$fechaCompleta." patente".$collectionOCR[0]->PATENTE;
                                if ($fechavalidacion != $fechaCompleta) {
                                    //return "es diferente ";
                                    DB::table('controlEmisionTicket')->insert([
                                        'fechaIngreso' => $collectionOCR[0]->FECHA,
                                        'horaIngreso' => $collectionOCR[0]->HORA,
                                        'fechaEmision' => $collectionOCR[0]->FECHA . " " . $collectionOCR[0]->HORA,
                                        'patenteTransporte' => $collectionOCR[0]->PATENTE,
                                        'statusEmision' => "N",
                                        'generacionRegistro' => "A"

                                    ]);
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
                                        //echo $hoy = date('d/m/Y g:ia');
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
                                        DB::table('controlEmisionTicket')->where('patenteTransporte', $request->patente)->update([
                                            'statusEmision' => "S"
                                        ]);
                                        return view('imprimir2', compact('collection2', 'patente'));
                                        //return view('imprimir2', compact('collection2'));

                                        //return view('imprimir', compact('Numero'));
                                    }
                                } else {
                                    //return "no es diferente ";
                                    return view('error');
                                }
                                //return "es igual o menor ".$fechaCompleta." patente".$collectionOCR[0]->PATENTE;

                            } else {
                                //return "NO lo es";
                                return view('error');
                            }



                        }
                    } else {
                        //return "ENCUENTRA DATA proceso de impresion cambia ESTATUS EMISION DE TICKET S";
                        if (empty($sp_validaReIngresoEmisionTicket)) {
                            //return "no encuentra data";

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
                                //echo $hoy = date('d/m/Y g:ia');
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
                                DB::table('controlEmisionTicket')->where('patenteTransporte', $request->patente)->update([
                                    'statusEmision' => "S"
                                ]);
                                return view('imprimir2', compact('collection2', 'patente'));
                                //return view('imprimir2', compact('collection2'));

                                //return view('imprimir', compact('Numero'));
                            }

                        } else {
                            return view('error');
                        }


                        //TERMINO EL PROCESO DE IMPRESION POR QUE ENCUENTRA DATA EN LA BASE DE DATOS 
                    }
                } else {
                    //return "ESTADO DE ACTIVIDAD 0 Proceso normal de impresion";
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
                }


                break;
            //ESTADO 3 FINALIZADO
            case '3':
                //return "CASO 3";

                $EstadoOCR = DB::table('AdminOCR')
                    ->select('estado_actividad')
                    ->first();

                if ($EstadoOCR->estado_actividad == 1) {
                    //return "ESTADO DE ACTIVIDAD 1";
                    $validaControlEmisionTicket = DB::connection('mysql')->select("CALL sp_validaControlEmisionTicket('$request->patente')");
                    $sp_validaReIngresoEmisionTicket = DB::connection('mysql')->select("CALL sp_validaReIngresoEmisionTicket('$request->patente')");
                    //return $sp_validaReIngresoEmisionTicket;
                    //return $validaControlEmisionTicket;
                    if (empty($validaControlEmisionTicket)) {

                        //return "NO ENCUENTRA DATA EN BD->busca en ws -> guarda DB -> proceso de impresion";
                        $parametros = [
                            'user' => 'tecap.ws',
                            'password' => 'ws.tecap',
                            'patente' => $request->patente,
                            //'patente' => 'RT4286',
                            //'folio' => $request->folio,
                        ];
                        $ch = curl_init('127.0.0.1/ws2/ws_ocr.php');
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parametros));

                        $responseOCR = curl_exec($ch);
                        curl_close($ch);
                        //dd($responseOCR);
                        if ($responseOCR == 'null') {
                            //Session::flash('patente', 'Acerquese a Oficina de Validaciones');        
                            return view('error');
                        }
                        if (!$responseOCR) {
                            //return false;
                            $collectionOCR = '';
                            return $collectionOCR;
                            //return view('imprimir', compact('collection', 'patente', 'folio'));
                        } else {
                            //dd(json_decode($response));
                            $collectionOCR = Collection::make(json_decode($responseOCR));
                            //dd($collectionOCR) ;

                            //echo $response;

                            //return $response;
                            if ($collectionOCR[0]->EXISTEOCR == 'N') {
                                //Session::flash('patente', 'Acerquese a Oficina de Validaciones');        
                                //return redirect()->back();
                                //return "Acerquese a Oficina de Validaciones";
                                return view('error'); //////Acerquese a Oficina de Validaciones
                            }
                            //return $collectionOCR;
                            // return $collectionOCR[0]->EXISTEOCR;
                            $fechaCompleta = $collectionOCR[0]->FECHA . " " . $collectionOCR[0]->HORA;
                            $fechaActual = date("Y-m-d H:i:s");
                            $horaMenos24 = date("Y-m-d H:i:s", strtotime($fechaActual . "-24 hour"));
                            @$fechavalidacion = $sp_validaReIngresoEmisionTicket[0]->fechaEmision;
                            if ($horaMenos24 <= $fechaCompleta) {
                                //return "es igual o menor ".$fechaCompleta." patente".$collectionOCR[0]->PATENTE;
                                if ($fechavalidacion != $fechaCompleta) {
                                    //return "es diferente ";
                                    DB::table('controlEmisionTicket')->insert([
                                        'fechaIngreso' => $collectionOCR[0]->FECHA,
                                        'horaIngreso' => $collectionOCR[0]->HORA,
                                        'patenteTransporte' => $collectionOCR[0]->PATENTE,
                                        'fechaEmision' => $collectionOCR[0]->FECHA . " " . $collectionOCR[0]->HORA,
                                        'statusEmision' => "N",
                                        'generacionRegistro' => "A"

                                    ]);
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
                                        //echo $hoy = date('d/m/Y g:ia');
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
                                        DB::table('controlEmisionTicket')->where('patenteTransporte', $request->patente)->update([
                                            'statusEmision' => "S"
                                        ]);
                                        return view('imprimir2', compact('collection2', 'patente'));
                                        //return view('imprimir2', compact('collection2'));

                                        //return view('imprimir', compact('Numero'));
                                    }
                                } else {
                                    //return "no es diferente ";
                                    return view('error');
                                }
                                //return "es igual o menor ".$fechaCompleta." patente".$collectionOCR[0]->PATENTE;

                            } else {
                                //return "NO lo es";
                                return view('error');
                            }

                        }


                    } else {
                        //return "ENCUENTRA DATA proceso de impresion cambia ESTATUS EMISION DE TICKET S";
                        if (empty($sp_validaReIngresoEmisionTicket)) {
                            //return "no encuentra data";
                            return view('error');
                        } else {

                            //return "ENCUENTRA DATA";

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
                                //echo $hoy = date('d/m/Y g:ia');
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
                                DB::table('controlEmisionTicket')->where('patenteTransporte', $request->patente)->update([
                                    'statusEmision' => "S"
                                ]);
                                return view('imprimir2', compact('collection2', 'patente'));
                                //return view('imprimir2', compact('collection2'));

                                //return view('imprimir', compact('Numero'));
                            }

                        }


                        //TERMINO EL PROCESO DE IMPRESION POR QUE ENCUENTRA DATA EN LA BASE DE DATOS 
                    }
                } else {
                    //return "ESTADO DE ACTIVIDAD 0 Proceso normal de impresion";
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
                }


                break;

            //ESTADO NO SE PRESENTO
            case '5':
                $EstadoOCR = DB::table('AdminOCR')
                    ->select('estado_actividad')
                    ->first();

                if ($EstadoOCR->estado_actividad == 1) {
                    //return "ESTADO DE ACTIVIDAD 1";
                    $validaControlEmisionTicket = DB::connection('mysql')->select("CALL sp_validaControlEmisionTicket('$request->patente')");
                    $sp_validaReIngresoEmisionTicket = DB::connection('mysql')->select("CALL sp_validaReIngresoEmisionTicket('$request->patente')");
                    //return $sp_validaReIngresoEmisionTicket;
                    //return $validaControlEmisionTicket;
                    if (empty($validaControlEmisionTicket)) {

                        //return "NO ENCUENTRA DATA EN BD->busca en ws -> guarda DB -> proceso de impresion";
                        $parametros = [
                            'user' => 'tecap.ws',
                            'password' => 'ws.tecap',
                            'patente' => $request->patente,
                            //'patente' => 'RT4286',
                            //'folio' => $request->folio,
                        ];
                        $ch = curl_init('127.0.0.1/ws2/ws_ocr.php');
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parametros));

                        $responseOCR = curl_exec($ch);
                        curl_close($ch);
                        //return $responseOCR;
                        if ($responseOCR == 'null') {
                            //Session::flash('patente', 'Acerquese a Oficina de Validaciones');        
                            return view('error');
                        }
                        if (!$responseOCR) {
                            //return false;
                            $collectionOCR = '';
                            return $collectionOCR;
                            //return view('imprimir', compact('collection', 'patente', 'folio'));
                        } else {
                            //dd(json_decode($response));
                            $collectionOCR = Collection::make(json_decode($responseOCR));
                            //dd($collectionOCR) ;

                            //echo $response;

                            //return $response;
                            if ($collectionOCR[0]->EXISTEOCR == 'N') {
                                //Session::flash('patente', 'Acerquese a Oficina de Validaciones');        
                                //return redirect()->back();
                                //return "Acerquese a Oficina de Validaciones";
                                return view('error'); //////Acerquese a Oficina de Validaciones
                            }
                            //return $collectionOCR;
                            // return $collectionOCR[0]->EXISTEOCR;
                            $fechaCompleta = $collectionOCR[0]->FECHA . " " . $collectionOCR[0]->HORA;
                            $fechaActual = date("Y-m-d H:i:s");
                            $horaMenos24 = date("Y-m-d H:i:s", strtotime($fechaActual . "-24 hour"));
                            @$fechavalidacion = $sp_validaReIngresoEmisionTicket[0]->fechaEmision;
                            if ($horaMenos24 <= $fechaCompleta) {
                                //return "es igual o menor ".$fechaCompleta." patente".$collectionOCR[0]->PATENTE;
                                if ($fechavalidacion != $fechaCompleta) {
                                    //return "es diferente ";
                                    //return "es igual o menor ".$fechaCompleta." patente".$collectionOCR[0]->PATENTE;
                                    DB::table('controlEmisionTicket')->insert([
                                        'fechaIngreso' => $collectionOCR[0]->FECHA,
                                        'horaIngreso' => $collectionOCR[0]->HORA,
                                        'patenteTransporte' => $collectionOCR[0]->PATENTE,
                                        'fechaEmision' => $collectionOCR[0]->FECHA . " " . $collectionOCR[0]->HORA,
                                        'statusEmision' => "N",
                                        'generacionRegistro' => "A"

                                    ]);
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
                                        //echo $hoy = date('d/m/Y g:ia');
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
                                        DB::table('controlEmisionTicket')->where('patenteTransporte', $request->patente)->update([
                                            'statusEmision' => "S"
                                        ]);
                                        return view('imprimir2', compact('collection2', 'patente'));
                                        //return view('imprimir2', compact('collection2'));

                                        //return view('imprimir', compact('Numero'));
                                    }
                                } else {
                                    //return "no es diferente ";
                                    return view('error');
                                }

                            } else {
                                //return "NO lo es";
                                return view('error');
                            }

                        }


                    } else {
                        //return "ENCUENTRA DATA proceso de impresion cambia ESTATUS EMISION DE TICKET S";
                        if (empty($sp_validaReIngresoEmisionTicket)) {
                            //return "no encuentra data";

                            return view('error');
                        } else {
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
                                //echo $hoy = date('d/m/Y g:ia');
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
                                DB::table('controlEmisionTicket')->where('patenteTransporte', $request->patente)->update([
                                    'statusEmision' => "S"
                                ]);
                                return view('imprimir2', compact('collection2', 'patente'));
                                //return view('imprimir2', compact('collection2'));

                                //return view('imprimir', compact('Numero'));
                            }


                        }


                        //TERMINO EL PROCESO DE IMPRESION POR QUE ENCUENTRA DATA EN LA BASE DE DATOS 
                    }
                } else {
                    //return "ESTADO DE ACTIVIDAD 0 Proceso normal de impresion";
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


    public function ajaxRequestGetHabilitacionTotem()
    {
        //estados iniciales
        // "id_bloq_horario": 1,
        // "fecha_bloq_horario": "2022-11-09",
        // "hora_inicio_bloq_horario": "12:00:00",
        // "hora_fin_bloq_horario": "13:00:00",
        // "horario_fijo_bloq_horario": 1,
        // "activa_bloqueo_bloq_horario": 1






        $activado_bloque = 0; ///activa bloqueo de horario 0: imprime & 1: no imprime
        $horarioFijoActivo = 0;
        $bloqueoDesbloqueoDirigido = 1;
        $mensaje = "";
        $fechaActual = date("Y-m-d");
        $HoraActual = date("H:i:s");
        $horaFinTotem = "";
        //$HoraActual ="21:10:00";
        $bloqueo_fijo = DB::table('bloqueo_horario')->where('horario_fijo_bloq_horario', '1')->get();
        $bloqueo = DB::table('bloqueo_horario')->where('horario_fijo_bloq_horario', '0')->get();
        //return $bloqueo;
        ////FOR de BLOQUEO FIJO
        for ($i = 0; $i < $data = count($bloqueo_fijo); $i++) {

            if (($bloqueo_fijo[$i]->hora_inicio_bloq_horario <= $HoraActual) && ($bloqueo_fijo[$i]->hora_fin_bloq_horario >= $HoraActual)) {
                //echo $bloqueo_fijo[$i]->hora_inicio_bloq_horario."id_registro:".$bloqueo_fijo[$i]->id_bloq_horario."<br>";
                $horarioFijoActivo = 1; //NO Puede imprimir
                $horaFinTotem = $bloqueo_fijo[$i]->hora_fin_bloq_horario;
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



        ///FOR DE BLOQUEO Y DESBLOQUEO DIRIGIDO
        for ($i = 0; $i < $data = count($bloqueo); $i++) {


            if ($bloqueo[$i]->fecha_bloq_horario == $fechaActual && $bloqueo[$i]->horario_fijo_bloq_horario == 0 && $bloqueo[$i]->activa_bloqueo_bloq_horario == 1 && ($HoraActual >= $bloqueo[$i]->hora_inicio_bloq_horario) && ($HoraActual <= $bloqueo[$i]->hora_fin_bloq_horario)) {
                //valido que horario_fijo_bloq_horario=0 y activa bloqueo este en 1: no imprime
                //////echo "no imprime id:".$bloq->id_bloq_horario;
                $activado_bloque = 1;
                //$mensaje="Totem Deshabilitado, Acerquese a ventanillas para mas información";
                $bloqueoDesbloqueoDirigido = 1;
                $horaFinTotem = $bloqueo[$i]->hora_fin_bloq_horario;


            } elseif ($bloqueo[$i]->fecha_bloq_horario == $fechaActual && $bloqueo[$i]->horario_fijo_bloq_horario == 0 && $bloqueo[$i]->activa_bloqueo_bloq_horario == 0 && ($HoraActual >= $bloqueo[$i]->hora_inicio_bloq_horario) && ($HoraActual <= $bloqueo[$i]->hora_fin_bloq_horario)) {
                //valido que horario_fijo_bloq_horario=0 y activa bloqueo este en 0: Imprime
                //////echo "imprime id:".$bloq->id_bloq_horario;
                $activado_bloque = 0;
                //$mensaje="Totem Habilitado";
                $bloqueoDesbloqueoDirigido = 0;
                //$horaFinTotem=$bloqueo[$i]->hora_fin_bloq_horario;
                //$mensaje="TOTEM DESHABILITADO, ACERQUESE A VENTANILLA PARA MAS INFORMACIÓN";
            } else {
                //no encuentra horario deja en esta de habilitado
                //echo "horario es fijo ".$HoraActual.$bloq->hora_inicio_bloq_horario."*******".$bloq->hora_fin_bloq_horario."<br>";
                //$activado_bloque=1;//no imprime
                //$mensaje="Totem Habilitado no se encuentran bloqueos y desbloqueos dirigidos";
                $bloqueoDesbloqueoDirigido = 3;
                //$horaFinTotem=$bloqueo[$i]->hora_fin_bloq_horario;  
                //$horaFinTotem="";        
            }


        }




        /// CASOS CON BLOQUEO FIJO ACTIVO // que no pueda imprimir
        if ($horarioFijoActivo == 1 && $bloqueoDesbloqueoDirigido == 1) {
            //echo "hay un bloqueo fijo y un bloqueo dirigido";
            $activado_bloque = 1; //no deja imprimir
            $mensaje = "Totem Deshabilitado Hasta las " . $horaFinTotem . " Hrs. Acerquese a ventanillas para mas información";
            $horaFinTotem;
        }
        if ($horarioFijoActivo == 1 && $bloqueoDesbloqueoDirigido == 0) {
            //echo "hay un bloqueo fijo y un desbloqueo dirigido";
            $activado_bloque = 0; //SI deja imprimir
            $mensaje = "Totem Habilitado";

        }
        if ($horarioFijoActivo == 1 && $bloqueoDesbloqueoDirigido == 3) {
            //echo "Solo hay un bloqueo fijo";
            $activado_bloque = 1; //NO deja imprimir
            $mensaje = "Totem Deshabilitado Hasta las " . $horaFinTotem . " Hrs. Acerquese a ventanillas para mas información";
            $horaFinTotem;
        }
        ///CASOS CON BLOQUEO FIJO DESACTIVADO //Que si pueda imprimir
        if ($horarioFijoActivo == 0 && $bloqueoDesbloqueoDirigido == 1) {
            //echo "NO hay un bloqueo fijo y un bloqueo dirigido";
            $activado_bloque = 1; //NO deja imprimir
            $mensaje = "Totem Deshabilitado Hasta las " . $horaFinTotem . " Hrs. Acerquese a ventanillas para mas información";
            $horaFinTotem;
        }
        if ($horarioFijoActivo == 0 && $bloqueoDesbloqueoDirigido == 0) {
            //echo "NO hay un bloqueo fijo y un desbloqueo dirigido";
            $activado_bloque = 0; //SI deja imprimir
            $mensaje = "Totem Habilitado";
        }
        if ($horarioFijoActivo == 0 && $bloqueoDesbloqueoDirigido == 3) {
            //echo "No Hay bloqueo fijo";
            $activado_bloque = 0; //SI deja imprimir
            $mensaje = "Totem Habilitado";
        }

        //echo $horarioFijoActivo."Msj:".$mensaje."<br>";
        //echo $bloqueoDesbloqueoDirigido."Msj:".$mensaje."<br>";




        $arr[] = array(
            'mensaje' => $mensaje,
            'activado_bloque' => $activado_bloque,
            'HorarioFinTotem' => $horaFinTotem,

        );




        //echo $arr;
        return $arr;
    }
}
