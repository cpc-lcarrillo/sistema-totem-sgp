<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Impresion Termica</title>
</head>
<body>

<img src="../img/logomonocromat.png" width="200px" height="100px">

<table class="table">
  <thead>
    <tr>
      <th scope="col">NUMERO DE ATENCION</th>
      
    </tr>
  </thead>
  <tbody>
  	@foreach($collection2 as $coleccion2)
    <tr>
      <th scope="row"><h1>{{$coleccion2[0]->numero_atencion}}</h1></th>
       @php
      $numeroAtencion=$coleccion2[0]->numero_atencion;
	  $uniqueids=$coleccion2[0]->uniqueid;
      @endphp
    </tr>
    <tr>
      <td>Patente : {{$patente}}</td>
      
    </tr>
    <tr>
    <td>UniqueID : {{@$uniqueids}}</td>
    <tr>
    
    <tr>      
        <td>Impresión
        : 
            @php
            date_default_timezone_set('America/Santiago');
            echo $hoy = date('d/m/Y g:ia');
			$fechatiempo=date('Y-m-d H:i:s');
            @endphp
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
{{-- @php
 use Illuminate\Support\Collection as Collection;
    $data = array(

            "uniqueid"    => @$uniqueids,
            "patente"     => $patente,
            "fechatiempo" => $fechatiempo,
            "ubicacion"   => '11',
            "folio"       => '',
            "guid"        => ''
        );
    $ch = curl_init("172.17.0.2:5001/ejecutarWSPuerto");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
            
            
            $response2 = curl_exec($ch);
            curl_close($ch);
            if(!$response2) {
            return false;
            }else{
              $collection2 = Collection::make(json_decode($response2));
              //return $collection2; 
            } 
    @endphp --}}
</body>
<script>
document.addEventListener("DOMContentLoaded", function(event) {
  imprimir(); 
});
redireccionar();
function redireccionar() {
    setTimeout("location.href='/totem'", 5000);
  }

   
function imprimir(cod_tpdf,jslinea, js_nro_mision)
  {
    
    fso = new ActiveXObject("Scripting.FileSystemObject");
    f1 = fso.CreateTextFile("C:\\IMPRESIONES\\"+"impreso"+".txt", true);

    // set fso = CreateObject("Scripting.FileSystemObject");
    // set s = fso.CreateTextFile("C:\\IMPRESIONES\\"+"impresora"+".txt", true);
    f1.writeline("      Número de Atención");
    f1.writeline("             <?php echo $numeroAtencion; ?>");    
    f1.writeline("--------------------------------");
    f1.writeline("PATENTE: <?php echo strtoupper($patente); ?>");
    f1.writeline("UniqueID: <?php echo @$uniqueids; ?>");
    
   
    f1.writeline("Impresión  : <?php date_default_timezone_set('America/Santiago');
        echo $hoy = date('d/m/Y g:ia');; ?>");
    f1.writeline("--------------------------------");
    f1.writeline("                                ");
    f1.writeline("                                ");
    f1.writeline("                                ");
    f1.writeline("--------------------------------");
    f1.Close();

    var objPrint=new ActiveXObject("Shell.Application");
    objPrint.ShellExecute("C:\\IMPRESIONES\\"+"impreso"+".txt","","","print",1);

  }      
</script>
</html>
