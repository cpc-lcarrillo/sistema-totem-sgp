<?php
include_once 'puertocoronelconfig.php'; //esta en carpeta public para tener las URLS de puertocoronel.
?>
<!doctype html>
<html lang="en">
  <head>
  
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    
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
  
  <MARQUEE SCROLLAMOUNT=7 class="colorpt" style="height: 50px; padding-bottom: auto;">
   <h1 class="text-white">PUEDES REGISTRAR TUS HORAS  ➜   <?php echo url_online();?>  </h1>
   </MARQUEE>
   
</nav>
 <h2><div class="bg-warning text-center" id="relojs" ></div></h2>

<div class="container-xl pt-3 ">
<div class="row">
  <div class="col-md-12 ">
    
    <div class="row">
      
      <div class="col-md-6  ">
         
        <table class="table table-sm  table-bordered text-center">
          <thead>
            <tr class="bg-warning">
              <th scope="col" width="50%">Atendiendo</th>
              <th scope="col" width="50%">Ventanilla</th>
              
            </tr>
          </thead>
          <tbody id="table_pantalla">
            <tr class="colorpt text-white">
              <td>&nbsp;</td>
              <td>&nbsp;</td>
             </tr>
             <tr class="colorpt text-white">
              <td>&nbsp;</td>
              <td>&nbsp;</td>
             </tr>
             <tr class="colorpt text-white">
              <td>&nbsp;</td>
              <td>&nbsp;</td>
             </tr>
             <tr class="colorpt text-white">
              <td>&nbsp;</td>
              <td>&nbsp;</td>
             </tr>
             <tr class="colorpt text-white">
              <td>&nbsp;</td>
              <td>&nbsp;</td>
             </tr>
             <tr class="colorpt text-white">
              <td>&nbsp;</td>
              <td>&nbsp;</td>
             </tr>
            
          </tbody>
        </table>
      
      <table class="table table-sm table-bordered text-center">
          <thead>
            
            <tr class="bg-warning">
              <th scope="col" width="50%">Patente</th>
              <th scope="col" width="50%">Destino</th>              
            </tr>
          </thead>
          <tbody id="table_destino"> 
           <tr class="colorpt text-white">
            <td><strong>FJXG-24</strong></td>
            <td><strong>BODEGA 10</strong></td>
           </tr>
           <tr class="colorpt text-white">
            <td><strong>XGFJ-23</strong></td>
            <td><strong>BODEGA 9</strong></td>
           </tr>
           <tr class="colorpt text-white">
            <td><strong>XGDJ-22</strong></td>
            <td><strong>BODEGA 8</strong></td>
           </tr>
           <tr class="colorpt text-white">
            <td><strong>XX76-05</strong></td>
            <td><strong>BODEGA 7</strong></td>
           </tr>
           <tr class="colorpt text-white">
            <td><strong>XX74-06</strong></td>
            <td><strong>BODEGA 1</strong></td>
           </tr>
           
           
           
          </tbody >
        </table> 
    {{-- <div class="col-md-8">  --}}   
    {{-- <iframe width="100%" scrolling="no" height="100%" src="http://operaciones.puertocoronel.cl/QRGestionFila_tv.php" frameborder="0" allowfullscreen></iframe> --}}
{{-- </div> --}}
        
      </div>

      <div class="col-md-6">
        <table class="table table-sm  table-bordered text-center">
          <thead>
            <tr class="bg-warning">
              <th scope="col">Su Turno</th>
              <th scope="col">V</th>              
            </tr>
          </thead>
          <tbody id="table_pantalla3">
            <tr class="colorpt text-white">
              <td>&nbsp;</td>
              <td>&nbsp;</td>
             </tr> 
           
            
          </tbody>
        </table>
            
        <table class="table table-sm  table-bordered text-center">
          <thead>
            <tr class="bg-warning">
              <th scope="col">Cantidad N°</th>
              <th scope="col">Nombre</th>   
              <th scope="col">Letra</th>              
            </tr>
          </thead>
          <tbody id="table_cola_Espera">
            <tr class="colorpt text-white">
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
             </tr> 
           
            
          </tbody>
          <tbody id="table_cola_Espera_total">
            <tr class="bg-warning">
              <td>&nbsp;</td>
              <td colspan="2"><center><h5>TOTAL</center></h5></td>
              
             </tr> 
           
            
          </tbody>
        </table>
            
   {{-- <table class="table table-sm table-bordered text-center mt-1">
          <thead>
            
            <tr class="bg-warning">
              <th scope="col">Atendidos</th>
              <th scope="col">V</th>              
            </tr>
          </thead>
          <tbody id="table_pantalla2"> 
           <tr class="colorpt text-white">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
           </tr>
           <tr class="colorpt text-white">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
           </tr>
           <tr class="colorpt text-white">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
           </tr>
          

           
           
          </tbody >
        </table> --}}

        <table class="table table-sm table-bordered text-center mt-1">
          <thead>
            
            <tr class="bg-warning">
              <th scope="col">Nombre</th>
              <th scope="col">Dry</th>    
              <th scope="col">Reefer</th> 
              <th scope="col">Totales</th>               
            </tr>
          </thead>
          <tbody id="table_colaespera"> 
           <tr class="colorpt text-white">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
           </tr>
           <tr class="colorpt text-white">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
           </tr>
           <tr class="colorpt text-white">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
           </tr>
          

           
           
          </tbody >
          <tbody id="table_colaespera_Total">
            <tr class="bg-warning">
              
              <td><center><h5>TOTAL</center></h5></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              
             </tr> 
           
            
          </tbody>
        </table>
      </div>
    {{-- <div class="col-12"> --}}
  
{{-- </div   --}}
    </div>

    <div class="row">
      <div class="col-md-1 ">
      </div>
      <div class="col-md-5 ">
        
        
      </div>
     
        
    
    
      
    </div>
    <div class="row">
      <div class="col-md-12 ">
        <audio id="myAudio">
        
          <source src="sound/alert.mp3" type="audio/mpeg">
          Your browser does not support the audio element.
        </audio>
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
document.reloj_javascript.reloj2.value = diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear()
document.write(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
</script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  </body>
</html>

<script type="text/javascript">

function Pantalla_Informativa(){
  var tabla= "";
  $.ajax({
    type:'GET',
    url:'ajaxPantallaultimollamado2',
  //async:false,
    data:{"_token": "gOeJPKsTjCq8Yal3uLW5Aq6Wlf0BuafYKrVUUbvK"},
    dataType: 'json',
  //async:false,
    success:function(data){
      
      //console.log(data);
    /*
      if (data == '') {
        for (var i = 0; i < 1; i++) {
          //console.log("valor"+i);
          
            tabla += ""+
            "<tr class='colorpt text-white'>"+         
              "<th>"+"&nbsp;"+"</th>"+
              "<td>"+"&nbsp;"+"</td>"+           
            "</tr>"            
            ;
            if(i == 1){
              break;
          }
        } 
        
      }else{*/
      var num =0;
      for(var i=0; i< data.length; i++  ){

        //console.log(data[i]);
        
    
    if(localStorage.getItem("alerta2_"+data[i].id_registro) != data[i].id_historico){
      //primera alerta que llega, asociada a ese id registro
      ////////console.log("NO EXISTE");
      //if (num > 2) {
      localStorage.setItem("alerta2_"+data[i].id_registro, data[i].id_historico);
      tabla += ""+
            "<tr class='coloralert text-danger '>"+         
              "<th><center><h3>"+data[i].turno+"</h3></center></th>"+
              "<td><center><h3>"+data[i].numero+"</h3></center></td>"+           
            "</tr>";
      document.getElementById("table_pantalla").innerHTML =tabla;
      //playAudio();
      break;
      
      //}
      
    }else{
      ///////console.log("EXISTE...");
      tabla += ""+
            "<tr class='colorpt text-white'>"+         
              "<th><center><h3>"+data[i].turno+"</h3></center></th>"+
              "<td><center><h3>"+data[i].numero+"</h3></center></td>"+           
            "</tr>";
      document.getElementById("table_pantalla").innerHTML =tabla;
      
    }
    
    
    /*
        if (data[i].alerta == 1) {
                tabla += ""+
            "<tr class='coloralert text-danger'>"+         
              "<th><center><h1>"+data[i].turno+"</h1></center></th>"+
              "<td><center><h1>"+data[i].numero+"</h1></center></td>"+           
            "</tr>";
            playAudio();
            
            break;
        }else{
          tabla += ""+
          "<tr class='coloralert text-danger'>"+         
              "<th><center><h1>"+data[i].turno+"</h1></center></th>"+
              "<td><center><h1>"+data[i].numero+"</h1></center></td>"+           
            "</tr>";
            
            break;
        }
            */ 
             
         




       } //CIERRO EL FOR
       //}
      
      
    }
  });

}  



setInterval(function(){
    Pantalla_Informativa();
},1000)


function Pantalla_Informativa_historico(){
  $.ajax({
    type:'GET',
    url:'ajaxPantallahistorico2',

    //data:{"_token": "gOeJPKsTjCq8Yal3uLW5Aq6Wlf0BuafYKrVUUbvK"},
    //dataType: 'json',
    success:function(data){
      var tabla= "";
      //console.log(data);
      if (data == '') {
        for (var i = 0; i < 6; i++) {
          //console.log("valor"+i);
          
            tabla += ""+
            "<tr class='colorpt text-white'>"+         
              "<th>"+"&nbsp;"+"</th>"+
              "<td>"+"&nbsp;"+"</td>"+           
            "</tr>"
            
            ;
            if(i == 6){
              break;
          }
        } 
        
      }else{
      var num =0;
      for(var i=0; i< data.length; i++  ){

        //console.log(data[i]);
        
               tabla += ""+
            "<tr class='colorpt text-white'>"+         
              "<th>"+data[i].turno+"</th>"+
              "<td>"+data[i].numero+"</td>"+           
            "</tr>";
          




         



       } //CIERRO EL FOR
      }
      //document.getElementById("table_pantalla2").innerHTML =tabla;
      
    }
  });

}
setInterval(function(){
  Pantalla_Informativa_historico();
},1000)

function Pantallaultimollamado(){
  var tabla= "";
  $.ajax({
    type:'GET',
    url:'ajaxPantallaultimollamado2',
  //async:false,
    data:{"_token": "gOeJPKsTjCq8Yal3uLW5Aq6Wlf0BuafYKrVUUbvK"},
    dataType: 'json',
  //async:false,
    success:function(data){
      
      //console.log(data);
    
      // if (data == '') {
      //   for (var i = 0; i < 1; i++) {
      //     console.log("valor"+i);
          
      //       tabla += ""+
      //       "<tr class='colorpt text-white'>"+         
      //         "<th>"+"&nbsp;"+"</th>"+
      //         "<td>"+"&nbsp;"+"</td>"+           
      //       "</tr>"            
      //       ;
      //      //break; 
      //   } 
        
      // }else{
      
      var num =0;
      for(var i=0; i< data.length; i++  ){

        //console.log(data[i]);
        
    
    if(localStorage.getItem("alerta_"+data[i].id_registro) != data[i].id_historico){
      //primera alerta que llega, asociada a ese id registro
      ////////console.log("NO EXISTE");
      localStorage.setItem("alerta_"+data[i].id_registro, data[i].id_historico);
      tabla += ""+
            "<tr class='coloralert text-danger'>"+         
              "<th><center><h2>"+data[i].turno+"</h2></center></th>"+
              "<td><center><h2>"+data[i].numero+"</h2></center></td>"+           
            "</tr>";
      document.getElementById("table_pantalla3").innerHTML =tabla;
      playAudio();

         //continue;
       break;

     
      
      
      
    }else{
      /////////console.log("EXISTE...");
       if (num > 1) {
        tabla += ""+
            "<tr class='colorpt text-danger'>"+         
              "<th><center><h2>&nbsp;</h2></center></th>"+
              "<td><center><h2>&nbsp;</h2></center></td>"+           
            "</tr>";
      document.getElementById("table_pantalla3").innerHTML =tabla;
      //playAudio();

      break;
      
       }
      // tabla += ""+
   //          "<tr class='coloralert text-danger'>"+         
   //            "<th><center><h1>"+data[i].turno+"</h1></center></th>"+
   //            "<td><center><h1>"+data[i].numero+"</h1></center></td>"+           
   //          "</tr>";
      // document.getElementById("table_pantalla3").innerHTML =tabla;
    }
    
    
    /*
        if (data[i].alerta == 1) {
                tabla += ""+
            "<tr class='coloralert text-danger'>"+         
              "<th><center><h1>"+data[i].turno+"</h1></center></th>"+
              "<td><center><h1>"+data[i].numero+"</h1></center></td>"+           
            "</tr>";
            playAudio();
            
            break;
        }else{
          tabla += ""+
          "<tr class='coloralert text-danger'>"+         
              "<th><center><h1>"+data[i].turno+"</h1></center></th>"+
              "<td><center><h1>"+data[i].numero+"</h1></center></td>"+           
            "</tr>";
            
            break;
        }
            */ 
             
         




       } //CIERRO EL FOR
       //}
      
   // }  
    }
  });

}
setInterval(function(){
  Pantallaultimollamado();
},1000)


function Pantallacolaespera(){
 $.ajax({
    type:'POST',
    url:'ajaxPantallacolaespera',

    data:{"_token": "{{ csrf_token() }}"},
    dataType: 'json',
    success:function(data){
      var tabla= "";
      var totales= "";
      var total= 0;
      //console.log(data);
      if (data == '') {
        for (var i = 0; i < 2; i++) {
          //console.log("valor"+i);
          
            tabla += ""+
            "<tr class='colorpt text-white'>"+         
              "<th>"+"&nbsp;"+"</th>"+
              "<th>"+"&nbsp;"+"</th>"+
              "<td>"+"&nbsp;"+"</td>"+           
            "</tr>"
            
            ;

            
            if(i == 1){
              totales += ""+      
       "<tr class='bg-warning'>"+                  
              "<th><center><h5>"+"0"+"</center></h5></th>"+
              "<th colspan='2'><center><h5>TOTAL"+"</center></h5></th>"+
              
            "</tr>";
              break;
          }
        } 
        
      }else{
      var num =0;
      for(var i=0; i< data.length; i++  ){

        //console.log(data[i]);
        
               tabla += ""+
            "<tr class='colorpt text-white'>"+         
              "<th><center><h5>"+data[i].cantidad+"</center></h5></th>"+
              "<td><center><h5>"+data[i].nombre+"</center></h5></td>"+    
              "<td><center><h5>"+data[i].letra+"</center></h5></td>"+           
            "</tr>";
          

            total += (parseInt(data[i].cantidad) || 0);
            //console.log(total);

              
           
            
 


       } //CIERRO EL FOR
       totales += ""+      
       "<tr class='bg-warning'>"+                  
              "<th><center><h5>"+total+"</center></h5></th>"+
              "<th colspan='2'><center><h5>TOTAL"+"</center></h5></th>"+
              
            "</tr>";
       //console.log(total);
      }
      document.getElementById("table_cola_Espera").innerHTML =tabla;
      document.getElementById("table_cola_Espera_total").innerHTML =totales;
      
    }
  });

}
setInterval(function(){
  Pantallacolaespera();
},1000)

function Pantallacolaespera2(){
 $.ajax({
    type:'POST',
    url:'ajaxPantallacolaespera22',

    data:{"_token": "{{ csrf_token() }}"},
    dataType: 'json',
    success:function(data){
      var tabla= "";
      var TotalColaEspera= "";
      var total= 0;
      var dryT = 0;
      var refeerT = 0;

      //console.log(data);
      if (data == '') {
        for (var i = 0; i < 4; i++) {
          //console.log("valor"+i);
          
            tabla += ""+
            "<tr class='colorpt text-white'>"+         
              "<th>"+"&nbsp;"+"</th>"+
              "<th>"+"&nbsp;"+"</th>"+
              "<td>"+"&nbsp;"+"</td>"+  
              "<td>"+"&nbsp;"+"</td>"+          
            "</tr>"
            
            ;
            if(i == 1){
              TotalColaEspera += ""+      
       "<tr class='bg-warning'>"+ 
             "<th><center><h5>TOTALES"+"</center></h5></th>"+                 
              "<th><center><h5>"+"0"+"</center></h5></th>"+
              "<th><center><h5>"+"0"+"</center></h5></th>"+
              "<th><center><h5>"+"0"+"</center></h5></th>"+

             
              
            "</tr>";  
              break;
          }
        } 
        
      }else{
      var num =0;
      var Dry="";
      var Refeer="";
      var CantidadTabla="";
      for(var i=0; i< data.length; i++  ){

        //console.log(data[i]);
            

        if(data[i].Dry === null){
          Dry="";
        }else{
          Dry=data[i].Dry
        }

        if(data[i].Refeer === null){
          Refeer="";
        }else{
          Refeer=data[i].Refeer;
        }
        if(data[i].cantidad === null){
          CantidadTabla="";
        }else{
          CantidadTabla=data[i].cantidad;
        }

               tabla += ""+
            "<tr class='colorpt text-white'>"+         
              "<th><center><h5>"+data[i].nombre_puerto+"</center></h5></th>"+              
              "<td><center><h5>"+Dry+"</center></h5></td>"+    
              "<td><center><h5>"+Refeer+"</center></h5></td>"+        
              "<td><center><h5>"+CantidadTabla+"</center></h5></td>"+   
            "</tr>";
          

          
            
            //console.log(total);

            dryT += (parseInt(data[i].Dry) || 0);
            refeerT += (parseInt(data[i].Refeer) || 0);
            total += (parseInt(data[i].cantidad) || 0);
         
            
 


       } //CIERRO EL FOR
       TotalColaEspera += ""+      
       "<tr class='bg-warning'>"+ 
             "<th><center><h5>TOTALES"+"</center></h5></th>"+                 
              "<th><center><h5>"+dryT+"</center></h5></th>"+
              "<th><center><h5>"+refeerT+"</center></h5></th>"+
              "<th><center><h5>"+total+"</center></h5></th>"+

             
              
            "</tr>";
       //console.log(total);
      }
      document.getElementById("table_colaespera").innerHTML =tabla;
      document.getElementById("table_colaespera_Total").innerHTML =TotalColaEspera;
      
    }
  });

}
setInterval(function(){
  Pantallacolaespera2();
},1000)


var x = document.getElementById("myAudio"); 

function playAudio() { 
  x.play(); 
} 

function pauseAudio() { 
  x.pause(); 
} 




</script>