<?php
include_once 'puertocoronelconfig.php'; //esta en carpeta public
?>

<!doctype html>
<html lang="en">
  <head>
  
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    
    {{-- <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Totem Atención</title>
     <style type="text/css">
      .colortres{
      background-color: #0f5c7e;
        }

        .coloruno{
          background-color:#e49e05;
        }
      .colordos{
          background-color:#67c1ea;
        }  

        .disabled {
    cursor: not-allowed;
    pointer-events: none;
} 
    </style>
  </head>
  <body >
<div class="container ">
  <!-- Stack the columns on mobile by making one full-width and the other half-width -->
  <div class="row">
    
    <div class="col"><center><img class="d-flex  align-content-end justify-content-center img-fluid"   src="img/logo.png"  ></center></div>
   
  </div>

  <div class="row">
{{-- <div class="col-12">
  <div class="d-flex justify-content-center">
     <a href="madera" class="btn coloruno btn-lg btn-block text-white">Madera</a>

  </div>
</div>    

<div class="col-12">
  <BR>
</div>
<div class="col-12">
  <div class="d-flex justify-content-center">
     <a href="celulosa" class="btn coloruno btn-lg btn-block text-white">Celulosa</a>

  </div>
</div>

<div class="col-12">
  <BR>
</div>
<div class="col-12">
  <div class="d-flex justify-content-center">
     <a href="reexpedicion" class="btn coloruno btn-lg btn-block text-white"> Reexpedición</a>

  </div>
</div>
<div class="col-12">
@if(Session::has('ERROR'))
<div class="alert alert-warning alert-dismissible fade in">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <h1>{{ Session::get('ERROR') }}</h1>
  </div>           
   @endif
  <BR>
</div> --}}


<!-- 1:No IMPRIME 
     0:IMPRIME
 -->
 <div class="col-12">
 <center><h3 id="msj"></h3></center>
 </div>
 <div class="col-12"><br></div>
<div class="col-12">
  <div class="d-flex justify-content-center">
     <a href="agendado" class="btn coloruno btn-lg btn-block text-white" id="activa" >ACO VACÍO</a>

  </div>
</div>
<div class="col-12">
  <BR>
</div>
<div class="col-12">
  <div class="d-flex justify-content-center">
     <a href="Deposito-Atencion-General-Dry" class="btn coloruno btn-lg btn-block text-white" id="activa2">Deposito-Atención General DRY</a>

  </div>
</div>

<div class="col-12">
  <BR>
</div>
<div class="col-12">
  <div class="d-flex justify-content-center">
     <a href="Deposito-Atencion-General-Refeer" class="btn coloruno btn-lg btn-block text-white" id="activa3">Deposito-Atención General REEFER</a>

  </div>
</div>

<div class="col-12">
  <BR>
</div>
<div class="col-12">
  <div class="d-flex justify-content-center">
     <a href="agendado" class="btn colortres btn-lg btn-block text-white" id="activa4">ACO FULL</a>

  </div>
</div>
<div class="col-12">
  <BR>
</div>

  





{{-- <div class="col-12">
  <div class="d-flex justify-content-center">
     <a href="cargasuelta2" class="btn colortres btn-lg btn-block text-white">Carga suelta</a>

  </div>
</div>
<div class="col-12">
  <BR>
</div>
<div class="col-12">
  <div class="d-flex justify-content-center">
     <a href="importacion" class="btn colortres btn-lg btn-block text-white">Importación</a>

  </div>
</div> --}}
<div class="col-12">
  <BR>
</div>

<div class="col-12">
  <iframe width="100%" height="700px" frameborder="0" src="<?php echo url_qr();?>" title="QR"></iframe>
</div>
 {{-- <div class="col-12">
  <div class="d-flex justify-content-center">
    <a href="noagendado" class="btn colorpt btn-lg btn-block text-white">No agendado</a>
    
  </div>
</div> --}}
<div class="col"><BR></div>
<div class="col-12 ">
  <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
    <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
    <li data-target="#carouselExampleCaptions" data-slide-to="3"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="img/sliders/slide1.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>PUERTO CORONEL</h5>
        <p>MÁS CERCANO, EFICIENTE Y TECNOLÓGICO</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="img/sliders/slide2.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>PUERTO CORONEL</h5>
        <p>MÁS CERCANO, EFICIENTE Y TECNOLÓGICO</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="img/sliders/slide3.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">        
        <h5>PUERTO CORONEL</h5>
        <p>MÁS CERCANO, EFICIENTE Y TECNOLÓGICO</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="img/sliders/slide4.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">        
        <h5>PUERTO CORONEL</h5>
        <p>MÁS CERCANO, EFICIENTE Y TECNOLÓGICO</p>
      </div>
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
</div>
  </div>

</div>
   
 

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  </body>
</html>
<script>
var ancla = document.getElementById('activa');
var ancla2 = document.getElementById('activa2');
var ancla3 = document.getElementById('activa3');
var ancla4 = document.getElementById('activa4');
var msj =document.getElementById('msj');
//var ancla = document.getElementsByClassName("btn");

  function HabilitacionTotem(){
  $.ajax({
    type:'GET',
    url:'HabilitacionTotem',

    //data:{"_token": "{{ csrf_token() }}"},
    dataType: 'json',
    success:function(data){      
      //console.log(data.mensaje);


      for(var i=0; i< data.length; i++  ){
        console.log(data[i].mensaje)
        //console.log(data[i].activado_bloque)

        if(data[i].activado_bloque === 1){ ///cambiar a 1
          console.log("desactivar botones");
          ancla.classList.add('disabled');
          ancla2.classList.add('disabled');
          ancla3.classList.add('disabled');
          ancla4.classList.add('disabled');
          msj.innerHTML=data[i].mensaje;
        }else{
          ancla.classList.remove('disabled');
          ancla2.classList.remove('disabled');
          ancla3.classList.remove('disabled');
          ancla4.classList.remove('disabled');
          msj.innerHTML='';
        }
      }

    }   
  });

}
setInterval(function(){
  HabilitacionTotem();
},1000)

    
   //const btncompra = document.getElementById('activa');
   //btncompra.disabled = false; 

   
       
            
                
            
        
    
      
</script>