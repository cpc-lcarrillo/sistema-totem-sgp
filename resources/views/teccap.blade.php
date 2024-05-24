
<!doctype html>
<html lang="en">
  <head>
    
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
     
<link rel="shortcut icon" href="{{asset('img/fondos/favicon.ico')}}">
<link href="{{ asset('css/icon.css')}}"
      rel="stylesheet">     
  
<link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<link rel="stylesheet" href="{{asset('css/all.css')}}" integrity="sha384-6jHF7Z3XI3fF4XZixAuSu0gGKrXwoX/w3uFPxC56OtjChio7wtTGJWRW53Nhx6Ev" crossorigin="anonymous">
  <!-- Custom fonts for this template-->
  
  <link href="{{ asset('css/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">


    
   <script type='text/javascript' src="{{ asset('js/jquery.min.js') }}"></script>
   <link href="{{ asset('css/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
   	
   
   

    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    
    <title>PANTALLA INFORMATIVA</title>
    <style type="text/css">
      .colorpt{
      background-color: #0f5c7e;
        }

        .coloralert{
      background-color: #FCFF33;
        }
        .sinpaddin{
          padding: 0;
        }

      td,th{
        border-radius: 5px/10px;
        
        
      }
      tr{
        border-top: 5%;
        
      }
    </style>
  </head>
  <body >
    
  <nav class="navbar  text-black sinpaddin">
    
  <img class="pt-2 " style="display:block; margin:auto;"  src="img/logo.png" width="250px" height="120px" >
  
  <!-- Navbar content -->
  
  <MARQUEE SCROLLAMOUNT=10 class="colorpt" style="height: 50px; padding-bottom: auto;">
   <h1 class="text-white">BUSQUEDA DE PATENTES EN ANTENAS - SISTEMA DE PRUEBAS TECCAP</h1>
   </MARQUEE>
   
</nav>
 <h2><div class="bg-warning text-center" id="relojs" ></div></h2>

<div class=" pt-3 ">
<div class="row">

  <div class="col-md-12 ">
    
    <div class="row">
        
        
        
        <div class="col-md-4">
        </div>
        <div class="col-md-4">
            <form class="form-inline" action="{{ route('teccap.store') }}" method="POST">
               @csrf    
                <div class="form-group mx-sm-3 mb-2">
                     
                  <select class="form-control" id="ubicacion" name="ubicacion" >
            
            @foreach($Ubicacion as $UbicacionAntena)
            <option value="{{$UbicacionAntena->id}}">N°{{$UbicacionAntena->id}}-{{$UbicacionAntena->nombre}}</option>
            @endforeach
          </select>  
                </div>
                <button type="submit" class="btn btn-primary mb-2">Buscar</button>
              </form>    
            

               
        </div>
        <div class="col-md-4">
            
        </div>
      <div class="col-md-12">
        
            <div class="table-responsive-lg"> <br>
<table class="table  table-hover table-dark table-bordered text-center " id="dataTable"  >
  <thead >
    
    	<tr >
      <th scope="col">#</th>
      <th scope="col">Fecha Lectura</th>
      <th scope="col">EPC</th>
      <th scope="col">Patente</th>
      <th scope="col">Cod.InternoTag</th>
      <th scope="col">IP.Antena</th>
      <th scope="col">Numero Antena</th>
      <th scope="col">NombreAntena</th>
      
      
    </tr>
    
  </thead>
  <tbody>
    @php
    $id=1;
    @endphp
  	@foreach($buscar_patente_antena as $BuscarPatente)
    
    <tr >
      <th scope="row">{{$id++}}</th>      
      <td>{{$BuscarPatente->fecha_primera_lectura}}</td>    
      <td>{{$BuscarPatente->EPC}}</td>    
      <td>{{$BuscarPatente->patente}}</td>    
      <td>{{$BuscarPatente->Cod_interno}}</td>    
      <td>{{$BuscarPatente->reader_ip}}</td>    
      <td>{{$BuscarPatente->numero_antena}}</td>    
      <td>{{$BuscarPatente->nombre}}</td>   
        
      
      </tr> 
   @endforeach
  </tbody>
</table>


</div>
         
        
       
    
    
   
      
{{-- DESDE AQUI SE ES LA CUARTA COLUMNA --}}
      
    </div>
    

</div>
</div>

<script>
    $(document).ready(function() {
      $('#dataTable').DataTable({
        
       "lengthMenu": [ 10, 20, 30, 40 ,50],
           
            
        "language": {
          "url": "js/datatable/Spanish.json",
          
          
                }
      });
    });
    
    
    </script>
    
    
    
    {{-- <script src="{{asset('js/demo/datatables-demo.js')}}"></script> --}}

    
  <!-- Bootstrap core JavaScript-->
  {{-- <script src="{{asset('js/jquery.min.js')}}"></script> --}}
  <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{asset('js/jquery.easing.min.js')}}"></script>

  <!-- Custom scripts for all pages-->

  <script src="{{asset('js/sb-admin-2.min.js')}}"></script>

  <!-- Page level plugins -->

  {{-- <script src="{{asset('js/Chart.min.js')}}"></script> --}}

  <!-- Page level custom scripts -->
  
  {{-- <script src="{{asset('js/chart-area-demo.js')}}"></script>
  <script src="{{asset('js/chart-pie-demo.js')}}"></script> --}}
<script type='text/javascript' src="{{asset('js/googlejquery.min.js')}}"></script>
<!-- Page level plugins -->
  <script src="{{asset('css/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('css/datatables/dataTables.bootstrap4.min.js')}}"></script>

	<script src="{{asset('js/jquery.mask.min.js')}}"></script>
	<script type='text/javascript' src="{{ asset('jQWidgets/jqxcore.js') }}"></script>
	<script type='text/javascript' src="{{ asset('jQWidgets/jqxchart.core.js') }}"></script>
	<script type='text/javascript' src="{{ asset('jQWidgets/jqxdraw.js') }}"></script>
	<script type='text/javascript' src="{{ asset('jQWidgets/jqxdata.js') }}"></script>




	
	<script type='text/javascript' src="{{ asset('jQWidgets/jqxdatetimeinput.js') }}"></script>
	<script type='text/javascript' src="{{ asset('jQWidgets/jqxcalendar.js') }}"></script>
	<script type='text/javascript' src="{{ asset('jQWidgets/jqxtooltip.js') }}"></script>
	<script type='text/javascript' src="{{ asset('jQWidgets/globalization/globalize.js') }}"></script>
	<script type='text/javascript' src="{{ asset('jQWidgets/globalization/globalize.culture.es.js') }}"></script>
  
  
    {{-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> --}}
  </body>
</html>
<script>
    document.ready = document.getElementById("ubicacion").value = {{@$ubicacionId}};
</script>
<script type="text/javascript">

// function Destino_Camion(){
//   $.ajax({
//     type:'GET',
//     url:'ajaxDestinoCamion2',

//     data:{"_token": "gOeJPKsTjCq8Yal3uLW5Aq6Wlf0BuafYKrVUUbvK"},
//     dataType: 'json',
//     success:function(data){
//       var tabla= "";
//       //console.log(data);
//       if (data == '') {
//         for (var i = 0; i < 6; i++) {
//           //console.log("valor"+i);
          
//             tabla += ""+
//             "<tr class='colorpt text-white'>"+         
//               "<th>"+"&nbsp;"+"</th>"+
//               "<td>"+"&nbsp;"+"</td>"+           
//             "</tr>"
            
//             ;
//             if(i == 6){
//               break;
//           }
//         } 
        
//       }else{
//       var num =0;
//       for(var i=0; i< data.length; i++  ){

//         //console.log(data[i]);
        
//                tabla += ""+
//             "<tr class='colorpt text-white'>"+         
//               "<th>"+data[i].patente+"</th>"+
//               "<th>"+data[i].destino_camion+"</th>"+           
//             "</tr>";
          




         



//        } //CIERRO EL FOR
//       }
//       document.getElementById("table_destino").innerHTML =tabla;
      
//     }
//   });

// }
// setInterval(function(){
//   Destino_Camion();
// },1000)



</script>

