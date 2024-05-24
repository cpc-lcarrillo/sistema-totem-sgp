<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Collection as Collection;
class ControllerPruebasTeccap extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $buscar_patente_antena = DB::connection('mysql')->select("CALL antena.buscar_patente_antena('')");

        $Ubicacion = DB::connection('mysql2')->table('ubicacion')->get();
        //$listaTAG = DB::connection('mysql2')->table('tag')->get();
        //return $Ubicacion;
        return view('teccap', compact('buscar_patente_antena','Ubicacion'));
        //return view('teccap');
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
        //return $request;
        $ubicacionId=$request->ubicacion;
        $buscar_patente_antena = DB::connection('mysql')->select("CALL antena.buscar_patente_antena('$ubicacionId')");

        $Ubicacion = DB::connection('mysql2')->table('ubicacion')->get();
        //$listaTAG = DB::connection('mysql2')->table('tag')->get();
        //return $Ubicacion;
        return view('teccap', compact('buscar_patente_antena','Ubicacion','ubicacionId'));
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
