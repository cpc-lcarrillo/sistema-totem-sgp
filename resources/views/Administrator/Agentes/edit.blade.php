@extends('Administrator.template.layout')

@section('content')
<h1 class="h3 mb-5 text-gray-800 ">Editar Agentes</h1>
<div class="card mb-4 py-3 border-bottom-primary">
<div class="container">


<form action="{{ route('Agentes.update', $listarAgentes->id) }}" method="POST">
  @csrf
  @method('PUT')   
 
  <div class="form-row">
    <div class="form-group col-md-6">
      <label >Nombre</label>
      <input type="text" class="form-control" name="nombre" value="{{$listarAgentes->nombre}}"  id="nombre" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ]{4,15}" title="Cantidad minima de caracteres es 4, no se permiten caracteres especiales" placeholder="Nombre" required>
      <span class="text-danger">{{$errors->first('nombre')}}</span>
    </div>
    <div class="form-group col-md-6">
      <label f>Usuario</label>
      <input type="text" class="form-control" name="usuario" value="{{$listarAgentes->usuario}}" id="Usuario" placeholder="jperez" required>
      <span class="text-danger">{{$errors->first('usuario')}}</span>
    </div>
    <div class="form-group col-md-6">
      <label>Password</label>
      <input type="password" class="form-control" name="clave" value="{{$listarAgentes->clave}}" id="clave" placeholder="password" required>
      <span class="text-danger">{{$errors->first('clave')}}</span>
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
