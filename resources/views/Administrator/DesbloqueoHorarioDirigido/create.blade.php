@extends('Administrator.template.layout')

@section('content')

          <!-- Page Heading -->
<!--<h1 class="h3 mb-5 text-gray-800 ">Crear excepción horaria IVR</h1>-->
 @if (Session::has('message'))
      <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif 

 
<div class="container-fluid">
  <div class="card mb-4 py-3 border-bottom-primary">
  <div class="card-body">
  
                
<form action="{{ route('DesbloqueoHorarioDirigido.store') }}" method="POST">
  @csrf
 
  <div class="form-row">
	<div class="form-group col-md-12">
		<h5 class="m-0 font-weight-bold text-primary">Crear Bloqueo/Desbloqueo Horario Dirigido</h5>
    </div>
        
    <div class="form-group col-md-12">
      <hr>      
    </div>
    @php 
    $hoy=date('Y-m-d');
    @endphp
    <div class="form-group col-md-3">
      <label for="inputEmail4">Fecha</label>
      <input class="form-control" type="DATE"  id="fecha" name="FECHA" min="{{$hoy}}" title="INGRESE UNA FECHA" required>
            
      <span class="text-danger">{{$errors->first('FECHA')}}</span>
    </div>
<div class="form-group col-md-2">
      <label for="inputEmail4">Horario Inicio</label>
      <input class="form-control" type="text" pattern="(0[0-9]|1[0-9]|2[0-3])(:[0-5][0-9]){2}" placeholder="00:00:00" id="INICIO" name="INICIO" title="EL FORMATO ES 00:00:00" required>      
      <span class="text-danger">{{$errors->first('INICIO')}}</span>
    </div>
    <div class="form-group col-md-2">
       <label for="inputEmail4">Horario Fin</label>
      <input class="form-control" type="text" pattern="(0[0-9]|1[0-9]|2[0-3])(:[0-5][0-9]){2}" placeholder="00:00:00" id="FIN" name="FIN" title="EL FORMATO ES 00:00:00" required>      
      <span class="text-danger">{{$errors->first('FIN')}}</span>
    </div>
    <div class="form-group col-md-3">
      <label for="inputEmail4">Bloqueo/Desbloqueo Horario Dirigido</label>
      <!-- <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input" id="customCheck1" name="Bloqueo" title="SI HABILITA BLOQUEO">
      <label class="custom-control-label" for="customCheck1">Activar Bloqueo</label> 
      </div>-->


      <div class="form-check">
  <input class="form-check-input" type="radio" name="Bloqueo" value="on" id="Bloqueo">
  <label class="form-check-label" for="Bloqueo">
    Activa Bloqueo
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="Bloqueo" value="off"  id="Desbloqueo" checked>
  <label class="form-check-label" for="Desbloqueo">
    Desactiva Bloqueo
  </label>
</div>
    </div>
      
    
    <div class="form-group col-md-3">
    
      
    </div>
    
<div class="form-group col-md-12">
      
    </div>
 
    
</div>
  <div class="form-group col-md-6">    
    <button type="submit" class="btn bg-gradient-primary ">Crear</button>
    <a class="btn bg-gradient-danger" href="./">Cancelar</a>   
   </div>
    </div>  

</form>   
</div> </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.15.0/umd/popper.min.js" integrity="sha384-L2pyEeut/H3mtgCBaUNw7KWzp5n9&#43;4pDQiExs933/5QfaTh8YStYFFkOzSoXjlTb" crossorigin="anonymous"></script>
<script src="https://unpkg.com/@coreui/coreui@3.0.0-alpha.12/dist/js/coreui.min.js" integrity="sha384-xzq5MjfYLblBm0qE9aJufGXDvVFxWcCH4BHpIl0a9DY02TG8AaQ8Jz6jccyZwSt1" crossorigin="anonymous"></script>

  <script>$(document).ready(function(){
  $('#INICIO').mask('00:00:00');
  $('#FIN').mask('00:00:00');
  
  
});</script>   
@endsection