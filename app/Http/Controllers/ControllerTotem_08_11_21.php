<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection as Collection;
use DB;
use Session;
use SoapClient;
Use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
Use Mike42\Escpos\Printer;
Use Mike42\Escpos\EscposImage;
Use Mike42\Escpos\PrintConnectors\FilePrintConnector;


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
        if ($request->folio == '' AND $request->patente == '') {
           Session::flash('folio',' El campo Folio está vacio.');
           Session::flash('patente',' El campo Patente está vacio.');
           return redirect()->back();
        }

       
        $patente=$request->patente;
        $folio=$request->folio;
$parametros = array(
    'user'=> "tecap.ws",
    'password'=> "ws.tecap",
    'patente'=> $request->patente,
    'folio'=> $request->folio

);
            $ch = curl_init("127.0.0.1/ws2/cliente.php");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($parametros));
            
            
            $response = curl_exec($ch);
            curl_close($ch);


            if ($response == "null") {
                Session::flash('patente',' La Patente o Folio no esta agendada.');

           return redirect()->back();
            }

            if(!$response) {
            //return false;
                $collection="";
               return view('imprimir', compact('collection','patente','folio'));  
            }else{
          //dd(json_decode($response));
            $collection = Collection::make(json_decode($response));
            //dd($collection) ;
          
                //echo $response;
 
           
           
        //return $response;
        return view('imprimir', compact('collection','patente','folio'));                   
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

        
        $folio=$id;
        $parametros = array(
        'user'=> "tecap.ws",
        'password'=> "ws.tecap",    
        'folio'=> $folio 
        );
            $ch = curl_init("127.0.0.1/ws2/cliente.php");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($parametros));
            
            
            $response = curl_exec($ch);
            curl_close($ch);
            if(!$response) {
            //return false;
                $collection="";
               return view('imprimir', compact('collection','patente','folio'));  
            }else{
          //dd(json_decode($response));
            $collection = Collection::make(json_decode($response));
            foreach ($collection as $valor) {
              $data = array(

            "patente"    => $valor->PATENTE,
            "mision"     => $valor->DESCRIPCIONOMISION,
            "id_empresa" => '1'
        );

            $ch = curl_init("127.0.0.1:5001/asignar_numero_atencion");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
            
            
            $response2 = curl_exec($ch);
            curl_close($ch);
            if(!$response2) {
            return false;
            }else{

                
             //    $responses = str_replace(array('[', ']'), '', htmlspecialchars(json_encode($response), ENT_NOQUOTES));
             //    $response = json_decode($responses,true) ;
            

             // $Numero = substr($response, 21, 4);
             
              $collection2 = Collection::make(json_decode($response2));
            
           
                //return $collection2;
            return view('show', compact('collection','collection2'));  


                //return view('show', compact('Numero','collection'));              
            } 
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
       $data = array(

            "patente"    => $request->patente,
            "mision"     => $request->mision,
            "id_empresa" => $id
        );

            $ch = curl_init("127.0.0.1:5001/asignar_numero_atencion");
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
            //    $responses = str_replace(array('[', ']'), '', htmlspecialchars(json_encode($response), ENT_NOQUOTES));
            //    $response = json_decode($responses,true) ;
            

            // $Numero = substr($response, 21, 4);
             
            $collection2 = Collection::make(json_decode($response));
            
            //return $collection2;
           
            //return $collection2;
        return view('imprimir2', compact('collection2')); 
           
                //return view('imprimir', compact('Numero'));                   
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
    
    public function ajaxRequestPostPantalla(){
        
         $data = DB::connection('mysql')->select("CALL pantalla_informativa(1)");
       
        return $data;
    }

    public function ajaxRequestPostPantallahistorico(){
        
        $data = DB::connection('mysql')->select("CALL pantalla_informativa_historico(1)");
      
       return $data;
   }

   public function ajaxRequestPostPantallaultimollamado(){
        
    $data = DB::connection('mysql')->select("CALL pantalla_informativa(1)");
  
   return $data;
}



public function ajaxRequestPostDestinoCamion(){

$data = DB::connection('mysql')->select("CALL pantalla_informativa_destino_camion()");
  
   return $data;
    
}

public function ajaxRequestPostPantallacolaespera(){

$data = DB::connection('mysql')->select("CALL sp_reporte_cola_espera(1)");
  
   return $data;
    
}



//////
    public function ajaxRequestPostPantalla2(){
        
         $data = DB::connection('mysql')->select("CALL pantalla_informativa_alerta(1)");
       
        return $data;
    }

    public function ajaxRequestPostPantallahistorico2(){
        
        $data = DB::connection('mysql')->select("CALL pantalla_informativa_historico(1)");
      
       return $data;
   }

   public function ajaxRequestPostPantallaultimollamado2(){
        
    $data = DB::connection('mysql')->select("CALL pantalla_informativa_alerta()");
  
   return $data;
}



public function ajaxRequestPostDestinoCamion2(){

$data = DB::connection('mysql')->select("CALL pantalla_informativa_destino_camion()");
  
   return $data;
    
}

public function ajaxRequestPostPantallacolaespera2(){

$data = DB::connection('mysql')->select("CALL sp_reporte_cola_espera(1)");
  
   return $data;
    
}


}
