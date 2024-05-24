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
      <th scope="col">Número de Atención</th>
      
    </tr>
  </thead>
  <tbody>
    @foreach($collection2 as $coleccion2)
    <tr>
      <th scope="row"><h1>{{$coleccion2[0]->numero_atencion}}</h1></th>
      @php
      $numeroAtencion=$coleccion2[0]->numero_atencion;
      $uniqueid=$coleccion2[0]->uniqueid;
      @endphp
    </tr>
    
    @endforeach
  </tbody>
</table>





<table class="table">
  <thead>
    @foreach($collection as $coleccion)
    <tr>
      <td style="background-color: #A3D7EF;">Orden - ACO N° <strong>{{$coleccion->IDENTIFICADOR}}</strong></td>
  @php
      $IDENTIFICADOR=$coleccion->IDENTIFICADOR;
      @endphp
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>{{$coleccion->DESCRIPCIONOMISION}}</td>
       @php
      $DESCRIPCIONOMISION=$coleccion->DESCRIPCIONOMISION;
      @endphp      
    </tr>
    @endforeach
  </tbody>
</table>


<table class="table">
  <thead>
    <tr>
      <td></td>
      <td></td>      
    </tr>
  </thead>
  <tbody>
      
    @foreach($collection as $coleccion)
    <tr>
      <td>Patente</td>
      <td>:{{$coleccion->PATENTE}}</td> 

    </tr>
    <tr>      
      <td>Rut</td>
      <td>:{{$coleccion->CHOFERRUT}}</td>
    </tr>
    <tr>      
      <td>Nombre</td>
      <td>:{{@$coleccion->CHOFERNOMBRE}}</td>
    </tr>
	<tr>      
      <td>Telefono</td>
      <td>:{{@$coleccion->CELULAR}}</td>
    </tr>
    <tr>      
      <td>Fecha</td>
      <td>:{{$coleccion->FECHA}}</td>
    </tr>
    <tr>      
      <td>Hora</td>
      <td>:{{$coleccion->HORA}}</td>
    </tr>
    <tr>      
      <td>Contenedor</td>
      <td>:{{$coleccion->CONTENEDOR}}</td>
    </tr>
    <tr>      
      <td>Reserva</td>
      <td>:{{$coleccion->DOCUMENTO}}</td>
    </tr>
    <tr>      
      <td>Nros DUS GU</td>
      <td>:{{$coleccion->DUS}}</td>
    </tr>
    <tr>      
      <td>Operador</td>
      <td>:{{$coleccion->OPERADOR}}</td>
    </tr>
    
    
    <tr>
    <td>UniqueID</td>
    <td>:{{@$uniqueid}}</td>
   
    </tr>
    <tr>      
      <td>Impresión</td>
      <td>: 
        @php
        date_default_timezone_set('America/Santiago');
        echo $hoy = date('d/m/Y g:ia');
$fechatiempo=date('Y-m-d H:i:s');
$fechatiempo2=date('Y_m_dH_i_s');
        @endphp
      </td>
    </tr>
    <tr>
    <td>
           
    @foreach($coleccion->MULTIPLE AS $multi)
    @if(!empty($multi->FILA1)) {{$multi->FILA1}} @endif <br>    
    @if(!empty($multi->FILA2)) {{$multi->FILA2}} @endif <br>
    @if(!empty($multi->FILA3)) {{$multi->FILA3}} @endif <br>
    @if(!empty($multi->FILA4)) {{$multi->FILA4}} @endif <br>
    @if(!empty($multi->FILA5)) {{$multi->FILA5}} @endif <br>
    @if(!empty($multi->FILA6)) {{$multi->FILA6}} @endif <br>
    @if(!empty($multi->FILA7)) {{$multi->FILA7}} @endif <br>
    @if(!empty($multi->FILA8)) {{$multi->FILA8}} @endif <br>
    @if(!empty($multi->FILA8)) {{$multi->FILA8}} @endif <br>
    @if(!empty($multi->FILA10)) {{$multi->FILA10}} @endif <br>
    @if(!empty($multi->FILA11)) {{$multi->FILA11}} @endif <br>
    @if(!empty($multi->FILA12)) {{$multi->FILA12}} @endif <br>
    @if(!empty($multi->FILA13)) {{$multi->FILA13}} @endif <br>
    @if(!empty($multi->FILA14)) {{$multi->FILA14}} @endif <br>
    @if(!empty($multi->FILA15)) {{$multi->FILA15}} @endif <br>
    @if(!empty($multi->FILA16)) {{$multi->FILA16}} @endif <br>
    @if(!empty($multi->FILA17)) {{$multi->FILA17}} @endif <br>
    @if(!empty($multi->FILA18)) {{$multi->FILA18}} @endif <br>
    @if(!empty($multi->FILA19)) {{$multi->FILA19}} @endif <br>
    @if(!empty($multi->FILA20)) {{$multi->FILA20}} @endif 

    @endforeach
    </td>
    
    </tr>




    @php
    $PATENTE=$coleccion->PATENTE;
    @endphp
    @php
    $CHOFERRUT=$coleccion->CHOFERRUT;
    $CHOFERNOMBRE=$coleccion->CHOFERNOMBRE;
    @endphp  
    @php
    $FECHA=$coleccion->FECHA;
    @endphp 
    @php
    $HORA=$coleccion->HORA;
    @endphp 
    @php
    $CONTENEDOR=$coleccion->CONTENEDOR;
    @endphp 
    @php
    $OPERADOR=$coleccion->OPERADOR;
	  $CELULAR=$coleccion->CELULAR;
    $DUS=$coleccion->DUS;
    $DOCUMENTO=$coleccion->DOCUMENTO;
    
    //$MULTIPLE[]=$coleccion->MULTIPLE;

    @endphp 
    

    @endforeach
    
    
  </tbody>
</table>


 {{-- @php
 use Illuminate\Support\Collection as Collection;
    $data = array(

            "uniqueid"    => @$uniqueid,
            "patente"     => $PATENTE,
            "fechatiempo" => $fechatiempo,
            "ubicacion"   => '11',
            "folio"       => $IDENTIFICADOR,
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
    @endphp       --}}
</body>
<script src="http://localhost/ImpresionTermica/jquery-3.1.1.min.js"></script>
<script>
  
document.addEventListener("DOMContentLoaded", function(event) {
  imprimir(); 
});
redireccionar();
function redireccionar() {
    setTimeout("location.href='/SGT/public/totem'", 5000);
  }



function imprimir(cod_tpdf,jslinea, js_nro_mision)
  {
    
var cod = "<?php echo "N°".$numeroAtencion."_".$fechatiempo2 ?>";

    // varjs_nmbArchivo='ACO'+cod_tpdf;
    // var fso, f1
    // var anchoTitulo = 11;
    // var anchoTotal  = 35;
    fso = new ActiveXObject("Scripting.FileSystemObject");
    f1 = fso.CreateTextFile("C:\\IMPRESIONES\\"+"Impreso"+cod+".txt", true);

    // set fso = CreateObject("Scripting.FileSystemObject");
    // set s = fso.CreateTextFile("C:\\IMPRESIONES\\"+"impresora"+".txt", true);
    f1.writeline("      Número de Atención");
    f1.writeline("             <?php echo $numeroAtencion; ?>");    
    f1.writeline("--------------------------------");
    f1.writeline("     Orden - Aco N°<?php echo $IDENTIFICADOR; ?>");
    f1.writeline("    <?php echo $DESCRIPCIONOMISION; ?>");
    f1.writeline("--------------------------------");
    f1.writeline("Patente    :<?php echo $PATENTE; ?>");
    f1.writeline("Rut        :<?php echo $CHOFERRUT; ?>");
    f1.writeline("Nombre     :<?php echo @$CHOFERNOMBRE; ?>");
	  f1.writeline("Telefono   :<?php echo @$CELULAR; ?>");
    f1.writeline("Fecha      :<?php echo $FECHA; ?>");
    f1.writeline("Hora       :<?php echo $HORA; ?>");
    f1.writeline("Contenedor :<?php echo $CONTENEDOR; ?>");
    f1.writeline("Reserva    :<?php echo $DOCUMENTO; ?>");
    f1.writeline("Nros Dus GU:<?php echo $DUS; ?>");
    f1.writeline("Operador   :<?php echo $OPERADOR; ?>");    
    f1.writeline("UniqueID   :<?php echo @$uniqueid; ?>"); 
    f1.writeline("Impresión  : <?php date_default_timezone_set('America/Santiago'); echo $hoy = date('d/m/Y g:ia'); ?>");
   
  //  f1.writeline("Comentarios: ");
   
   <?php 
  //  $num=1;
   foreach ($collection as $colec2) {
    
    foreach ($colec2->MULTIPLE as $multi) {
       if (!empty($multi->FILA1)){ echo 'f1.writeline("'.@$multi->FILA1.'");';} ;
       if (!empty($multi->FILA2)){echo 'f1.writeline("'.@$multi->FILA2.'");';};
       if (!empty($multi->FILA3)){echo 'f1.writeline("'.@$multi->FILA3.'");';};
       if (!empty($multi->FILA4)){echo 'f1.writeline("'.@$multi->FILA4.'");';};
       if (!empty($multi->FILA5)){echo 'f1.writeline("'.@$multi->FILA5.'");';};
       if (!empty($multi->FILA6)){echo 'f1.writeline("'.@$multi->FILA6.'");';};
       if (!empty($multi->FILA7)){echo 'f1.writeline("'.@$multi->FILA7.'");';};
       if (!empty($multi->FILA8)){echo 'f1.writeline("'.@$multi->FILA8.'");';};
       if (!empty($multi->FILA9)){echo 'f1.writeline("'.@$multi->FILA9.'");';};
       if (!empty($multi->FILA10)){echo 'f1.writeline("'.@$multi->FILA10.'");';};
       if (!empty($multi->FILA11)){echo 'f1.writeline("'.@$multi->FILA11.'");';};
       if (!empty($multi->FILA12)){echo 'f1.writeline("'.@$multi->FILA12.'");';};
       if (!empty($multi->FILA13)){echo 'f1.writeline("'.@$multi->FILA13.'");';};
       if (!empty($multi->FILA14)){echo 'f1.writeline("'.@$multi->FILA14.'");';};
       if (!empty($multi->FILA15)){echo 'f1.writeline("'.@$multi->FILA15.'");';};
       if (!empty($multi->FILA16)){echo 'f1.writeline("'.@$multi->FILA16.'");';};
       if (!empty($multi->FILA17)){echo 'f1.writeline("'.@$multi->FILA17.'");';};
       if (!empty($multi->FILA18)){echo 'f1.writeline("'.@$multi->FILA18.'");';};
       if (!empty($multi->FILA19)){echo 'f1.writeline("'.@$multi->FILA19.'");';};
       if (!empty($multi->FILA20)){echo 'f1.writeline("'.@$multi->FILA20.'");';};
      //echo $comentario->MULTIPLE."FILA".$num;
      //echo "f1.writeline('Comentarios   :".$comentario->FILA.$num."');";
      //echo 'console.log("'.$comentario->FILA.$num.'")';

    } } 
    ?>;
    

    f1.writeline("--------------------------------");
    
    f1.Close();

    var objPrint=new ActiveXObject("Shell.Application");
    objPrint.ShellExecute("C:\\IMPRESIONES\\"+"Impreso"+cod+".txt","","","print",1);

  }    
</script>
</html>
