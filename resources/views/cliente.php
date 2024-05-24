<?php

include_once 'lib/nusoap.php';
$cliente = new nusoap_client("https://ws.puertocoronel.cl/servicios/CLCTecap/CLCTecap.wsdl",
	true);

$user="tecap.ws";
$password="ws.tecap";
$patente="PJ6804";
$folio="";

$parametros = array(
	'user'=> $user,
	'password'=> $password,
	'patente'=> $patente,
	'folio'=> $folio

);
$respuesta = $cliente->call("CLCTecap",$parametros);

$longitud = count($respuesta);

//print_r($respuesta);
 // $id=0;
 // foreach ($respuesta as $key) {
 // 	echo $key[$id]["FECHA"]."<BR>";
 // 	echo $key[$id]["CONTENEDOR"]."<BR>";
 // }

foreach($respuesta as $respuesta1)
 	{
 	
 	foreach($respuesta1 as $respuesta2)
 		{
 		echo"Patente: ".$respuesta2["PATENTE"]."<BR>";
 		echo"Fecha - Hora Solicitud: ".$respuesta2["FECHA"]." ".$respuesta2["HORA"]."<BR>";
 		echo"Patente: ".$respuesta2["IDENTIFICADOR"]."<BR>";
 		echo"Numero de Misión: ".$respuesta2["NUMEROMISION"]."<BR>";
 		echo"Nombre de Misión: ".$respuesta2["DESCRIPCIONOMISION"]."<BR><BR><BR>";
 		
 		}
 	
 	}
?>