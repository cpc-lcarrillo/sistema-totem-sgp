<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>REIMPRESIÓN TICKET</title>
</head>

<body>
  <img src="../img/logomonocromat.png" width="200px" height="100px">

  <table class="table">
    <thead>
      <tr>
        <th scope="col">Reimpresión Número de Atención</th>

      </tr>
    </thead>
    <tbody>
      @foreach($ValidacionRe_Imprimir as $coleccion2)
      <tr>
        <th scope="row">
          <h1>{{$coleccion2->numero_atencion}}</h1>
        </th>
        @php
        $numeroAtencion=$coleccion2->numero_atencion;
        //$uniqueid=$coleccion2[0]->uniqueid;
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
      <td>
    <br>
    @foreach($coleccion->MULTIPLE AS $multi)
    @if(!empty($multi->FILA1)) {{$multi->FILA1}} @endif <br>    
    @if(!empty($multi->FILA2)) {{$multi->FILA2}} @endif <br>
    @if(!empty($multi->FILA3)) {{$multi->FILA3}} @endif <br>
    @if(!empty($multi->FILA4)) {{$multi->FILA4}} @endif <br>
    @if(!empty($multi->FILA5)) {{$multi->FILA5}} @endif <br>
    @if(!empty($multi->FILA6)) {{$multi->FILA6}} @endif <br>
    @if(!empty($multi->FILA7)) {{$multi->FILA7}} @endif <br>
    @if(!empty($multi->FILA8)) {{$multi->FILA8}} @endif <br>
    @if(!empty($multi->FILA9)) {{$multi->FILA9}} @endif <br>
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

      @endphp


      @endforeach
      

    </tbody>
  </table>


  @foreach($collection AS $colec22)
  @foreach($colec22->MULTIPLE AS $multi)
      @php    $fila1=utf8_encode(@$multi->FILA1);  @endphp
      @php    $fila2=utf8_encode(@$multi->FILA2);  @endphp
      @php    $fila3=utf8_encode(@$multi->FILA3);  @endphp
      @php    $fila4=utf8_encode(@$multi->FILA4);  @endphp
      @php    $fila5=utf8_encode(@$multi->FILA5);  @endphp
      @php    $fila6=utf8_encode(@$multi->FILA6);  @endphp
      @php    $fila7=utf8_encode(@$multi->FILA7);  @endphp
      @php    $fila8=utf8_encode(@$multi->FILA8);  @endphp
      @php    $fila9=utf8_encode(@$multi->FILA9);  @endphp
      @php    $fila10=utf8_encode(@$multi->FILA10);  @endphp
      @php    $fila11=utf8_encode(@$multi->FILA11);  @endphp
      @php    $fila12=utf8_encode(@$multi->FILA12);  @endphp
      @php    $fila13=utf8_encode(@$multi->FILA13);  @endphp
      @php    $fila14=utf8_encode(@$multi->FILA14);  @endphp
      @php    $fila15=utf8_encode(@$multi->FILA15);  @endphp
      @php    $fila16=utf8_encode(@$multi->FILA16);  @endphp
      @php    $fila17=utf8_encode(@$multi->FILA17);  @endphp
      @php    $fila18=utf8_encode(@$multi->FILA18);  @endphp
      @php    $fila19=utf8_encode(@$multi->FILA19);  @endphp
      @php    $fila20=utf8_encode(@$multi->FILA20);  @endphp


    
@endforeach
@endforeach
</body>
<script>
  document.addEventListener("DOMContentLoaded", function(event) {
    imprimir();
  });
  redireccionar();

  function redireccionar() {
    setTimeout("location.href='/totem'", 5000);
  }



  function imprimir(cod_tpdf, jslinea, js_nro_mision) {

    
    var cod = "<?php echo "N°".$numeroAtencion."_".$fechatiempo2 ?>";
    // varjs_nmbArchivo='ACO'+cod_tpdf;
    // var fso, f1
    // var anchoTitulo = 11;
    // var anchoTotal  = 35;
    fso = new ActiveXObject("Scripting.FileSystemObject");
    f1 = fso.CreateTextFile("C:\\IMPRESIONES\\" + "ReImpreso"+cod+ ".txt", true);

    // set fso = CreateObject("Scripting.FileSystemObject");
    // set s = fso.CreateTextFile("C:\\IMPRESIONES\\"+"impresora"+".txt", true);
    f1.writeline("         Reimpresión");
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
    // f1.writeline("UniqueID   :<?php echo @$uniqueid; ?>");
    f1.writeline("Impresión  : <?php date_default_timezone_set('America/Santiago'); echo $hoy = date('d/m/Y g:ia'); ?>");

    <?php 
      if (!empty($fila1)){echo 'f1.writeline("'.trim(@$fila1).'");';};
      if (!empty($fila2)){echo 'f1.writeline("'.trim(@$fila2).'");';};
      if (!empty($fila3)){echo 'f1.writeline("'.trim(@$fila3).'");';};
      if (!empty($fila4)){echo 'f1.writeline("'.trim(@$fila4).'");';};
      if (!empty($fila5)){echo 'f1.writeline("'.trim(@$fila5).'");';};
      if (!empty($fila6)){echo 'f1.writeline("'.trim(@$fila6).'");';};
      if (!empty($fila7)){echo 'f1.writeline("'.trim(@$fila7).'");';};
      if (!empty($fila8)){echo 'f1.writeline("'.trim(@$fila8).'");';};
      if (!empty($fila9)){echo 'f1.writeline("'.trim(@$fila9).'");';};
      if (!empty($fila10)){echo 'f1.writeline("'.trim(@$fila10).'");';};
      if (!empty($fila11)){echo 'f1.writeline("'.trim(@$fila11).'");';};
      if (!empty($fila12)){echo 'f1.writeline("'.trim(@$fila12).'");';};
      if (!empty($fila13)){echo 'f1.writeline("'.trim(@$fila13).'");';};
      if (!empty($fila14)){echo 'f1.writeline("'.trim(@$fila14).'");';};
      if (!empty($fila15)){echo 'f1.writeline("'.trim(@$fila15).'");';};
      if (!empty($fila16)){echo 'f1.writeline("'.trim(@$fila16).'");';};
      if (!empty($fila17)){echo 'f1.writeline("'.trim(@$fila17).'");';};
      if (!empty($fila18)){echo 'f1.writeline("'.trim(@$fila18).'");';};
      if (!empty($fila19)){echo 'f1.writeline("'.trim(@$fila19).'");';};
      if (!empty($fila20)){echo 'f1.writeline("'.trim(@$fila20).'");';};
    ?>



    
    
    
   
  
    f1.writeline("--------------------------------");

    f1.Close();

    var objPrint = new ActiveXObject("Shell.Application");
    objPrint.ShellExecute("C:\\IMPRESIONES\\" + "ReImpreso" +cod+ ".txt", "", "", "print", 1);

  }
</script>

</html>
