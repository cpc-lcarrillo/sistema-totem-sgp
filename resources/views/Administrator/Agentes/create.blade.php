@extends('Administrator.template.layout')

@section('content')


          <!-- Page Heading -->
<h1 class="h3 mb-5 text-gray-800 ">Agregar Agentes</h1>
<div class="card mb-4 py-3 border-bottom-primary">

<div class="container-fluid">
<form action="{{ route('Agentes.store') }}" method="POST">
  @csrf

  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Nombre</label>
      <input type="text" class="form-control" name="nombre"  id="nombre"  placeholder="Nombre" required>
      <span class="text-danger">{{$errors->first('Nombre')}}</span>
    </div>
    <div class="form-group col-md-6">
      <label for="inputEmail4">Usuario</label>
      <input type="text" class="form-control" name="usuario"  id="usuario" placeholder="jperez" required>
      <span class="text-danger">{{$errors->first('usuario')}}</span>
    </div>
    <div class="form-group col-md-6">
      <label for="inputEmail4">Password</label>
      <input type="password" class="form-control" name="clave" id="Password" placeholder="Password" required>
      <span class="text-danger">{{$errors->first('clave')}}</span>
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