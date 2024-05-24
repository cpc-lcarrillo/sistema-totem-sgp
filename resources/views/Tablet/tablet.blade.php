<!doctype html>
<html lang="en">
  <head>
  
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    
    <title>Reportes Ingreso</title>
    <style type="text/css">
    	 option { color:white; background-color:#0f5c7e; }
       option:hover { color:white; background-color:white; }
      .colorpt {
    	background-color: #0f5c7e;
      

    		}

        .coloralert{
    	background-color: #FCFF33;
    		}
        .sinpaddin{
          padding: 0;
        }

      td,th{
        border-radius: 5px/15px;
        
        
      }
      tr{
        border-top: 10%;
        
      }
    </style>
  </head>
  <body >
    
  <nav class="navbar  text-black sinpaddin">
    
  <img class="pt-2 " style="display:block; margin:auto;"  src="img/logo.png" width="250px" height="120px" >
  
  <!-- Navbar content -->
  
  
   
</nav>
 <h2><div class="bg-warning text-center" id="relojs" ></div></h2>

<div class="container-xl pt-3 ">
<div class="row">
  <div class="col-md-12 ">
    
    <div class="row">
      <div class="col-md-12">
        <center><h1>Consulta Ingresos de Camiones </h1></center>
        
         <select class="form-control" name="campo" id="campo" onchange="Cambio_Mision('1');">
              @foreach($listamisiones as $misiones)
              @if($misionsession == $misiones->id)
               <option value="{{$misionsession}}" selected="true">{{$valueMisionsession}}</option>
              @else  
              <option value="{{$misiones->id}}" >{{$misiones->nombre}}</option>
              @endif
              @endforeach
            </select>
      </div>
      <div class="col-md-12">
      </br>
      </div>

      <div class="col-md-12  ">

        <table class="table table-sm  table-bordered text-center">
          <thead>
            <tr class="bg-warning">

              <th scope="col">Patente</th>              
              <th scope="col">Misión</th>
              <th scope="col">Estado Atención</th>
              <th scope="col">Destino</th>
              
              
            </tr>
          </thead>
          <tbody id="table_pantalla_tablet">
            <tr class="colorpt text-white">
              <td></td> 
              <td></td>
              <td></td>
              <td></td>
             </tr>
             
            
          </tbody>
        </table>
      
      
      </div>
      <div class="col-md-6">
      </div>      
    </div>
    <div class="row">
      <div class="col-md-1 ">
      </div>
      <div class="col-md-5 ">
        
        
      </div>
     
        
    
    
      
    </div>
    <div class="row">
      <div class="col-md-12 ">
        
  </div>

</div>
</div>

{{-- <div class="fixed-bottom">
<nav class="navbar navbar-dark colorpt text-white">

<div class="mx-auto" style="width: 100%;">
  <MARQUEE SCROLLAMOUNT=15 >
   <h3>ESTO ES UN EJEMPLO DE LO QUE SE PUEDE AGREGAR EN ESTE CONTENEDOR</h3>
   </MARQUEE>
</div>
</nav>
</div> --}}

	<script>
		reloj();
		function reloj() {
			//Variables
			var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
			var f=new Date()
			horareal = new Date()
			hora = horareal.getHours()
			minuto = horareal.getMinutes()
			segundo = horareal.getSeconds()
			//Codigo para evitar que solo se vea un numero en los segundos
			comprobarsegundo = new String (segundo)
			if (comprobarsegundo.length == 1)
			segundo = "0" + segundo
			//Codigo para evitar que solo se vea un numero en los minutos
			comprobarminuto = new String (minuto)
			if (comprobarminuto.length == 1)
			minuto = "0" + minuto
			//Codigo para evitar que solo se vea un numero en las horas
			comprobarhora = new String (hora)
			if (comprobarhora.length == 1)
			hora = "0" + hora
			// Codigo para mostrar el reloj en pantalla
			verhora = hora + " : " + minuto + " : " + segundo
			//document.reloj_javascript.reloj.value = verhora

			document.getElementById("relojs").innerHTML = verhora + " " + diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear()
			setTimeout("reloj()",1000)


		}
	</script>
	<script>
var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
var f=new Date();
//document.reloj_javascript.reloj2.value = diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear()
//document.write(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
</script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  </body>
</html>

<script type="text/javascript">

function Cambio_Mision(value){  
var mision = document.getElementById("campo").value;
console.log(mision);


var campomision = document.getElementById("campo");
var valueMision = campomision.options[campomision.selectedIndex].text;

var misionstorage=localStorage.setItem('mision', mision);
var valuemisionstorage=localStorage.setItem('valueMision', valueMision);
 
  callCambiarmision(misionstorage,valuemisionstorage);
  
}

function callCambiarmision(mision, valueMision){

  var mision = localStorage.getItem('mision');
  var valueMision = localStorage.getItem('valueMision');
 
    $.ajax({
      type:'POST',
      url:'ajaxTablet',
      data:{"mision": mision,"_token": "{{ csrf_token() }}","valueMision":valueMision},
      dataType: 'json',
      success:function(data){
      var tabla= "";
      console.log(data);
      if (data == '') {
        for (var i = 0; i < 1; i++) {
          //console.log("valor"+i);
          
            tabla += ""+
            "<tr class='colorpt text-white'>"+         
              "<th>"+"&nbsp;"+"</th>"+
              "<td>"+"&nbsp;"+"</td>"+    
               "<td>"+"&nbsp;"+"</td>"+        
            "</tr>"            
            ;
            if(i == 1){
              break;
          }
        } 
        
      }else{
      var num =0;
      for(var i=0; i< data.length; i++  ){

        //console.log(data[i]);
        
        
          tabla += ""+
          "<tr class='colorpt text-white'>"+         
              "<th><center><h3>"+data[i].patente+"</h3></center></th>"+
              "<td><center><h3>"+data[i].NombreMision+"</h3></center></td>"+  
              "<td><center><h3>"+data[i].NombreEstadoRegistro+"</h3></center></td>"+
              "<td>"
              +"<div class='form-group'>"+    
               "<select  class='form-control'>"+
                "<option>MUELLE</option>"+
                "<option>PATIO 1</option>"+
                "<option>DEPOSITO CLC</option>"+
                "<option>YARD CLC</option>"+
                "<option>BODEGA 3</option>"+
                "<option>BODEGA 4</option>"+
                "<option>BODEGA 5</option>"+
                "<option>BODEGA 6</option>"+
                "<option>BODEGA 7</option>"+
                "<option>BODEGA CAMELIAS</option>"+
                "<option>BODEGA 10</option>"+
                "<option>BODEGA 11</option>"+
                "<option>BODEGA 12</option>"+
                "<option>BODEGA 14</option>"+
                "<option>BODEGA YOBILO</option>"+
                "<option>BODEGA DELSAVA</option>"+
                "</select></div>"  
                +"</td>"+            
                "</tr>";
            
           
        
             
             
         




       } //CIERRO EL FOR
       }
      document.getElementById("table_pantalla_tablet").innerHTML =tabla;
      
    }

    });
  
}





setInterval(function(){
  callCambiarmision();
},8000)

var x = document.getElementById("myAudio"); 

function playAudio() { 
  x.play(); 
} 

function pauseAudio() { 
  x.pause(); 
} 




</script>