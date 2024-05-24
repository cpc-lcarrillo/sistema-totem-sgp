<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection as Collection;
use DB;
use Session;

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
        $data = array(

            "patente"    => $request->patente,
            "mision"     => $request->mision,
            "id_empresa" => $request->id_empresa
        );

            $ch = curl_init("172.16.21.0:5001/asignar_numero_atencion");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
            
            
            $response = curl_exec($ch);
            curl_close($ch);
            if(!$response) {
            return false;
            }else{

                //$array = json_decode($response, true);
            //return view('imprimir', compact('response'));
               $responses = str_replace(array('[', ']'), '', htmlspecialchars(json_encode($response), ENT_NOQUOTES));
               $response = json_decode($responses,true) ;
            

            $Numero = substr($response, 21, 4);
             
              
           
                return view('imprimir', compact('Numero'));                   
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
        //
    }

    public function ajaxRequestPostPantalla(){
        
         $data = DB::connection('mysql')->select("CALL pantalla_informativa(1)");
       
        return $data;
    }
}
