<!doctype html>
<html lang="en">
  <head>
  
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    
    {{-- <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    
	

    
    <title>Deposito-Atención General DRY</title>
    
  </head>
  <body >
<div class="container ">
  <!-- Stack the columns on mobile by making one full-width and the other half-width -->
  <div class="row">
    
    <div class="col"><center><img class="d-flex  align-content-end justify-content-center img-fluid"   src="img/logo.png"  ></center></div>
   
  </div>

  <form id="formABC" action="{{ route('totem.update',1) }}" method="POST">
    @csrf
    @method('PUT')   
<div class="form-group row">
    
    <div class="col-sm-3">
     
    </div>

    <label for="staticEmail" class="col-sm-1 col-form-label-lg">Patente:</label>
    <div class="col-sm-3">
    	<input type="hidden" name="mision" value="Deposito-Atencion-General-Dry">
      <input type="text"  class="form-control" name="patente" maxlength="7" onkeyup="javascript:this.value=this.value.toUpperCase();" id="patente" size="12" placeholder="ej. LL0NNN" required="" autofocus>
      <input type="hidden" name="id_empresa" value="1">
	  <span class="text-danger">{{$errors->first('patente')}}</span>
@if (Session::has('message'))
   <p class="text-danger">{{ Session::get('message') }}</p>
 @endif
    </div>    
    <div class="col">
      <button type="submit" class="btn btn-primary" id="activa">Buscar</button>
        
      <a href="Deposito-Atencion-General-Dry" class="btn btn-primary">Limpiar</a>
     
        
    
      <a href="totem" class="btn btn-primary">Volver</a>
    </div>
  </div>
</form>

<div class="col-12">
  <BR>
</div>
 <div class="col-12">
  <div class="d-flex justify-content-center">


 



 
    
  </div>
</div>
<div class="col"><BR></div>
<div class="col-12">
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
  
  <script>

// $("#patente").on("keyup", function() {
//   var x = $("#patente").val();
//       alert(x);
// });


// $( "#patente" ).blur(function() {
//       // alert( "Handler for .blur() called." );
//       var x = $("#patente").val();
//       alert(x);
//       // tu codigo ajax va dentro de esta function...
//     });


    
  </script>
  </body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
var ancla = document.getElementById('activa');
var ancla1 = document.getElementById('patente');

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
          ancla1.classList.add('disabled');
          ancla1.disabled = true;
          $("#formABC").submit(function (e) {

            //stop submitting the form to see the disabled button effect
            e.preventDefault();
            
            return true;

            });
          
          window.history.back();
          //msj.innerHTML=data[i].mensaje;
        }else{
          ancla.classList.remove('disabled');
          
          //msj.innerHTML='';
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