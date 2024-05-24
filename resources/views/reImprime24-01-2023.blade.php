<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Re-IMPRESION TICKET</title>
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
      <tr>
        <td>Impresión</td>
        <td>:
          @php
          date_default_timezone_set('America/Santiago');
          echo $hoy = date('d/m/Y g:ia');
          $fechatiempo=date('Y-m-d H:i:s');
          @endphp
        </td>
      </tr>

    </tbody>
  </table>



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



  function imprimir(cod_tpdf, jslinea, js_nro_mision) {
    // varjs_nmbArchivo='ACO'+cod_tpdf;
    // var fso, f1
    // var anchoTitulo = 11;
    // var anchoTotal  = 35;
    fso = new ActiveXObject("Scripting.FileSystemObject");
    f1 = fso.CreateTextFile("C:\\IMPRESIONES\\" + "impreso" + ".txt", true);

    // set fso = CreateObject("Scripting.FileSystemObject");
    // set s = fso.CreateTextFile("C:\\IMPRESIONES\\"+"impresora"+".txt", true);
    f1.writeline("      Re-Impresión");
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
    f1.writeline("Impresión  : <?php date_default_timezone_set('America/Santiago');
                                echo $hoy = date('d/m/Y g:ia'); ?>");
    f1.writeline("--------------------------------");

    f1.Close();

    var objPrint = new ActiveXObject("Shell.Application");
    objPrint.ShellExecute("C:\\IMPRESIONES\\" + "impreso" + ".txt", "", "", "print", 1);

  }
</script>

</html>