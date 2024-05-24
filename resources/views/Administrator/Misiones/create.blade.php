@extends('Administrator.template.layout')

@section('content')


          <!-- Page Heading -->
<h1 class="h3 mb-5 text-gray-800 ">Agregar Misión</h1>
<div class="card mb-4 py-3 border-bottom-primary">

<div class="container-fluid">
<form action="{{ route('Misiones.store') }}" method="POST">
  @csrf

  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Nombre</label>
      <input type="text" class="form-control" name="nombre"  id="nombre" title="Nombre de misión" placeholder="Nombre de misión" required>
      <span class="text-danger">{{$errors->first('Nombre')}}</span>
    </div>
    <div class="form-group col-md-6">
      <label>Tipo de mision</label>
      <select class="form-control" name="tipo_mision" id="tipo_mision">
      <option value=0>Deposito-Atencion-General</option>
      <option value=1>Retiro Contenedor Full</option>
      <option value=2>Retiro Contenedor Vacio</option>
      <option value=3>Entrega Contenedor Full</option>
      <option value=4>Entrega Contenedor Vacio</option>
    </select>      
      <span class="text-danger">{{$errors->first('tipo_mision')}}</span>
    </div>
    <div class="form-group col-md-6">
      <label>Tipo de contenedor</label>
      <select class="form-control" name="tipo_contenedor" id="tipo_contenedor">
      <option value="">Sin tipo de contenedor</option>
      <option value="Dry">Dry</option>
      <option value="Refeer">Refeer</option> 
    </select>      
      <span class="text-danger">{{$errors->first('tipo_contenedor')}}</span>
    </div>
    <div class="form-group col-md-6">
      <label>Horario</label>
      <select class="form-control" name="horario" id="horario">
      <option value="">Sin horario</option>
      <option value="Bloque">Bloque</option>
      <option value="Fuera">Fuera</option> 
    </select>      
      <span class="text-danger">{{$errors->first('horario')}}</span>
    </div>
   
    <div class="form-group col-md-6">
      <label for="inputEmail4">Letra Ticket</label>
      <input type="text" class="form-control" name="letra_ticket"  id="letra_ticket" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ]{0,5}" title="Cantidad minima de caracteres es 4, no se permiten caracteres especiales (SOLO TEXTO)" placeholder="Nombre" required>
      <span class="text-danger">{{$errors->first('Nombre')}}</span>
    </div>
    
    
    
     {{-- <div class="form-group col-md-6">
    <label for="exampleFormControlSelect1">Empresa</label>
    <select class="form-control" id="exampleFormControlSelect1" name="DBIDEM">
      @foreach($listaEmpresa as $Empresa)
      <option value="{{$Empresa->DBIDEM}}">{{$Empresa->Nombre}}</option>
      @endforeach
           
    </select>
    <span class="text-danger">{{$errors->first('DBIDEM')}}</span>
  </div> --}}
  {{-- <div class="form-group col-md-6"
</div> --}}
  
  <div class="form-group col-md-12">
    
  </div>  
    <div class="col-md-5">
    <button type="submit" class="btn bg-gradient-primary ">Crear</button>
    <a class="btn bg-gradient-danger" href="./">Cancelar</a>
    </div>
    
</form>
</div>
</div>
</div>
   

    
@endsection