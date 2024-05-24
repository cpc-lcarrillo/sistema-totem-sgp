@extends('Administrator.template.layout')

@section('content')
<h1 class="h3 mb-5 text-gray-800 ">Editar usuarios</h1>
<div class="card mb-4 py-3 border-bottom-primary">
<div class="container">


<form action="{{ route('Users.update', $listarusuarios->id_usuario) }}" method="POST">
  @csrf
  @method('PUT')   
 
  <div class="form-row">
    <div class="form-group col-md-6">
      <label f>Usuario</label>
      <input type="email" class="form-control" name="Usuario" value="{{$listarusuarios->usuario}}" id="Usuario" placeholder="contacto@puertocoronel.cl" required>
      <span class="text-danger">{{$errors->first('Usuario')}}</span>
    </div>
    <div class="form-group col-md-6">
      <label>Password</label>
      <input type="password" class="form-control" name="password" value="{{$listarusuarios->password}}" id="password" placeholder="password" required>
      <span class="text-danger">{{$errors->first('password')}}</span>
    </div>
    <div class="form-group col-md-6">
      <label >Nombre</label>
      <input type="text" class="form-control" name="nombre" value="{{$listarusuarios->nombre}}"  id="nombre" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ]{4,15}" title="Cantidad minima de caracteres es 4, no se permiten caracteres especiales" placeholder="Nombre" required>
      <span class="text-danger">{{$errors->first('nombre')}}</span>
    </div>
    <div class="form-group col-md-6">
      <label>Apellido</label>
      <input type="text" class="form-control" name="apellido" value="{{$listarusuarios->apellido}}" id="apellido " pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ]{4,15}" title="Cantidad minima de caracteres es 4, no se permiten caracteres especiales" placeholder="apellido" required>
      <span class="text-danger">{{$errors->first('ApellidoPA')}}</span>
    </div>
    
    <div class="form-group col-md-6">
      <label for="inputEmail4">Rut</label>
      <input type="number" class="form-control" name="rut" id="rut" placeholder="10098333" value="{{$listarusuarios->rut}}" maxlength="8" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(8, this.maxLength);" required="">
      <span class="text-danger">{{$errors->first('rut')}}</span>
    </div>
   <div class="form-group col-md-6">
      <label for="inputEmail4">DV</label>
      <input type="text" class="form-control" name="dv" id="dv" placeholder="K" value="{{$listarusuarios->dv}}" maxlength="1" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(8, this.maxLength);" required="">
      <span class="text-danger">{{$errors->first('dv')}}</span>
    </div>
     {{-- <div class="form-group col-md-6">
    <label for="exampleFormControlSelect1">Empresa</label>
    <select class="form-control" id="exampleFormControlSelect1" name="DBIDEM">
    @foreach($listaEmpresa as $empresas)
     @if($listarusuarios->DBIDEM === $empresas->DBIDEM)
      <option value="{{$listarusuarios->DBIDEM}}" selected="true" >{{$listarusuarios->NombreEmpresa}}</option>
    @else
      <option value="{{$empresas->DBIDEM}}">{{$empresas->Nombre}}</option> 

    @endif
    
    @endforeach
    </select>
    <span class="text-danger">{{$errors->first('DBIDEM')}}</span>
  </div> --}}
  
<div class="form-group col-md-12">
</div>
    <div class="col-md-5">
    <button type="submit" class="btn bg-gradient-primary ">Actualizar</button>
    <a class="btn bg-gradient-danger" href="../">Cancelar</a>
    </div>
  </div>
</div>
</div>
</form>
@endsection
