@extends('Administrator.template.layout')

@section('content')
<h1 class="h3 mb-5 text-gray-800 ">Editar Ventanilla</h1>
<div class="card mb-4 py-3 border-bottom-primary">
<div class="container">


<form action="{{ route('Ventanillas.update', $listarVentana->id) }}" method="POST">
  @csrf
  @method('PUT')   
 
  <div class="form-row">    

    <div class="form-group col-md-6">
      <label for="inputEmail4">Nombre Ventanillas</label>
      <input type="text" class="form-control" name="nombre"  id="nombre" value="{{$listarVentana->nombre}}" placeholder="Ventanillas 1" required>
      <span class="text-danger">{{$errors->first('nombre')}}</span>
    </div>    
    
    <div class="form-group col-md-6">
      <label for="inputEmail4">Número Ventanilla</label>
      <input type="number" class="form-control" name="numero" id="numero" value="{{$listarVentana->numero}}" placeholder="10" maxlength="2" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(1, this.maxLength);" required="">
    </div>
   
    <div class="form-group col-md-6">
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
