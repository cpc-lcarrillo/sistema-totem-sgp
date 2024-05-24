<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Collection as Collection;
class ControllerReportAtendidos extends Controller
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
$agentes = DB::table('agente')->where('id_empresa',$id_DBDT = session('id_DBDEM'))->where('estado_agente','1')->get();
        //MENU DINAMICO
        $ReportTAtendidos = DB::connection('mysql')->select("CALL sp_reporte_atendidos('0')");
        
        

        
        // $listaDistribucion = DB::table('distribucion')
        // ->select(   'distribucion.id as id_distribucion',
        //             'ventana.nombre as nombre_ventana',
        //             'mision.nombre as nombre_mision',
        //             'distribucion.prioridad',
        //             'distribucion.fecha_creacion',
        //             'mision.id as id_mision',
        //             'ventana.id as id_ventana')
        // ->join('mision', 'distribucion.id_mision', '=', 'mision.id')
        //  ->join('ventana', 'distribucion.id_ventana', '=', 'ventana.id')
        // ->where('distribucion.estado_distribucion', '1')
        // ->get();
        //->where('usuario.DBIDUS', $id)->first();
        
return view('/Administrator/Atendidos-por-Agentes.index', compact('ReportTAtendidos','agentes'));
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
        //return $request->id_agente;

        $agentess = DB::table('agente')->where('id',$request->id_agente)->first();

        $agentes = DB::table('agente')->where('id','<>',$request->id_agente)->get();

        session(['id_agente' => $agentess->id]);

        session(['nombre_agente' => $agentess->nombre]);

       

        $ReportTAtendidos = DB::connection('mysql')->select("CALL sp_reporte_atendidos($request->id_agente)");
       return view('/Administrator/Atendidos-por-Agentes.index', compact('ReportTAtendidos','agentes'));
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
        //
    }
}
