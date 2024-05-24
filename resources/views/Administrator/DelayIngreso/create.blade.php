@extends('Administrator.template.layout')

@section('content')


          <!-- Page Heading -->
<h1 class="h3 mb-5 text-gray-800 ">Agregar usuarios</h1>
<div class="card mb-4 py-3 border-bottom-primary">

<div class="container-fluid">
<form action="{{ route('Users.store') }}" method="POST">
  @csrf

  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Usuario</label>
      <input type="email" class="form-control" name="Usuario"  id="Usuario" placeholder="contacto@puertocoronel.cl" required>
      <span class="text-danger">{{$errors->first('Usuario')}}</span>
    </div>
    <div class="form-group col-md-6">
      <label for="inputEmail4">Password</label>
      <input type="password" class="form-control" name="password" id="Password" placeholder="Password" required>
      <span class="text-danger">{{$errors->first('password')}}</span>
    </div>
    <div class="form-group col-md-6">
      <label for="inputEmail4">Nombre</label>
      <input type="text" class="form-control" name="nombre"  id="nombre" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ]{4,15}" title="Cantidad minima de caracteres es 4, no se permiten caracteres especiales (SOLO TEXTO)" placeholder="Nombre" required>
      <span class="text-danger">{{$errors->first('Nombre')}}</span>
    </div>
    <div class="form-group col-md-6">
      <label for="inputEmail4">Apellido</label>
      <input type="text" class="form-control" name="apellido" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ]{4,15}" id="Apellido Paterno" title="Cantidad minima de caracteres es 4, no se permiten caracteres especiales (SOLO TEXTO)" placeholder="Apellido Paterno" required>
      <span class="text-danger">{{$errors->first('ApellidoPA')}}</span>
    </div>
    
    <div class="form-group col-md-6">
      <label for="inputEmail4">Rut</label>
      <input type="number" class="form-control" name="rut" id="rut" placeholder="10098333" maxlength="8" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required="">
    </div>
    <div class="form-group col-md-1">
      <label for="inputEmail4">DV</label>
      <input type="text" class="form-control" name="dv" id="dv" placeholder="K" maxlength="1" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required="">
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