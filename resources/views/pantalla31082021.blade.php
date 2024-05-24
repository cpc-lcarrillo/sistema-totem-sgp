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
    
  <img class="pt-2 " style="display:block; margin-left: :10px; "   src="img/logo.png" width="250px" height="120px" >
  <iframe class="pt-2 "   scrolling="no" style="margin-right:90px;" src="http://operaciones.puertocoronel.cl/QRGestionFila_tv.php" frameborder="0" allowfullscreen></iframe>
  <!-- Navbar content -->
  
  <MARQUEE SCROLLAMOUNT=7 class="colorpt" style="height: 50px; padding-bottom: auto;">
   <h1 class="text-white">PUEDES REGISTRAR TUS HORAS  ➜   https://online.puertocoronel.cl </h1>
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
        <script src="https://hls-js.netlify.com/dist/hls.js"></script>
        <div class="embed-responsive embed-responsive-16by9">
    <video  id="video" width="100%" height="100%"   controls autoplay preload="auto" >
        
    </video>
        </div>
    <script>
     document.getElementsByTagName("body")[0].onclick= function(){
 
         var el = document.documentElement;
        var rfs = // for newer Webkit and Firefox
            el.requestFullScreen
            || el.webkitRequestFullScreen
            || el.mozRequestFullScreen
            || el.msRequestFullScreen
                ;
                if(typeof rfs!="undefined" && rfs){
                    rfs.call(el);
                } else if(typeof window.ActiveXObject!="undefined"){
                // for Internet Explorer
                var wscript = new ActiveXObject("WScript.Shell");
                if (wscript!=null) {
                    wscript.SendKeys("{F11}");
                }
                }
    }   
        
    if(Hls.isSupported())
    {
        var video = document.getElementById('video');
        
        
        var hls = new Hls();
        hls.loadSource('https://mdstrm.com/live-stream-playlist/57d1a22064f5d85712b20dab.m3u8?PlaylistM3UCL');
        hls.attachMedia(video);
        hls.on(Hls.Events.MANIFEST_PARSED,function()
        {
            video.play();
           
        });
    }
    
    else if (video.canPlayType('application/x-mpegURL'))
    {
        video.src = 'https://mdstrm.com/live-stream-playlist/57d1a22064f5d85712b20dab.m3u8?PlaylistM3UCL';
        video.addEventListener('canplay',function()
        {
            video.play();
            
            
        });
    }
    </script>
    
   <table class="table table-sm table-bordered text-center mt-1">
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
          {{--  <tr class="colorpt text-white">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
           </tr>
           <tr class="colorpt text-white">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
           </tr> --}}

           
           
          </tbody >
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
  $.ajax({
    type:'POST',
    url:'ajaxPantalla',

    data:{"_token": "{{ csrf_token() }}"},
    dataType: 'json',
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
            if(i == 5){
              break;
          }
        } 
        
      }else{
      var num =0;
      for(var i=0; i< data.length; i++  ){
        
        console.log('vacio');
        switch (data[i].id_estado) {
          case 1:
          tabla += ""+
            "<tr class='colorpt text-white'>"+         
              "<th><center><h3>"+"</h3></center></th>"+
              "<td><center><h3>"+"</h3></center></td>"+           
            "</tr>";
          break;
          case 2:
              if (data[i].alerta == 1) {
                tabla += ""+
            "<tr class='coloralert text-white'>"+         
              "<th><center><h3>"+data[i].turno+"</h3></center></th>"+
              "<td><center><h3>"+data[i].numero+"</h3></center></td>"+           
            "</tr>";
            playAudio();
             
              }else{

          tabla += ""+
            "<tr class='colorpt text-white'>"+         
              "<th><center><h3>"+data[i].turno+"</h3></center></th>"+
              "<td><center><h3>"+data[i].numero+"</h3></center></td>"+           
            "</tr>";
          }
          break;
          case 3:
          break;
          case 4:
          if (data[i].alerta == 1) {
              tabla += ""+
            "<tr class='coloralert text-danger'>"+         
              "<th><center><h3>"+data[i].turno+"</h3></center></th>"+
              "<td><center><h3>"+data[i].numero+"</h3></center></td>"+           
            "</tr>";            
            playAudio();
          }else{
            tabla += ""+
            "<tr class='colorpt text-white'>"+         
              "<th><center><h3>"+data[i].turno+"</h3></center></th>"+
              "<td><center><h3>"+data[i].numero+"</h3></center></td>"+           
            "</tr>";
          } 
          break;      
          
          default:
          tabla += ""+
            "<tr class='colorpt text-white'>"+         
              "<th>"+"</th>"+
              "<td>"+"</td>"+           
            "</tr>";
            break;
          
         
          
        }
        
        
       } //CIERRO EL FOR
      }
      document.getElementById("table_pantalla").innerHTML =tabla;
      
    }
  });

}



setInterval(function(){
    Pantalla_Informativa();
},1000)


function Pantalla_Informativa_historico(){
  $.ajax({
    type:'POST',
    url:'ajaxPantallahistorico',

    data:{"_token": "{{ csrf_token() }}"},
    dataType: 'json',
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
      document.getElementById("table_pantalla2").innerHTML =tabla;
      
    }
  });

}
setInterval(function(){
  Pantalla_Informativa_historico();
},1000)

function Pantallaultimollamado(){
  $.ajax({
    type:'POST',
    url:'ajaxPantallaultimollamado',

    data:{"_token": "{{ csrf_token() }}"},
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
        
        if (data[i].alerta == 1) {
                tabla += ""+
            "<tr class='coloralert text-danger'>"+         
              "<th><center><h3>"+data[i].turno+"</h3></center></th>"+
              "<td><center><h3>"+data[i].numero+"</h3></center></td>"+           
            "</tr>";
            playAudio();
            
            break;
        }else{
          tabla += ""+
          "<tr class='coloralert text-danger'>"+         
              "<th><center><h3>"+data[i].turno+"</h3></center></th>"+
              "<td><center><h3>"+data[i].numero+"</h3></center></td>"+           
            "</tr>";
            
            break;
        }
             
             
         




       } //CIERRO EL FOR
       }
      document.getElementById("table_pantalla3").innerHTML =tabla;
      
    }
  });

}
setInterval(function(){
  Pantallaultimollamado();
},1000)

var x = document.getElementById("myAudio"); 

function playAudio() { 
  x.play(); 
} 

function pauseAudio() { 
  x.pause(); 
} 




</script>