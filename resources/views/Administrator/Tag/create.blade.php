@extends('Administrator.template.layout')

@section('content')


          <!-- Page Heading -->
<h1 class="h3 mb-5 text-gray-800 ">Agregar Tag</h1>
<div class="card mb-4 py-3 border-bottom-primary">

<div class="container-fluid">
<form action="{{ route('Tag.store') }}" method="POST">
  @csrf

  <div class="form-row">
    <div class="form-group col-md-6">
      <label f>Cod.Interno</label>
      <input type="text" class="form-control" name="Cod_interno" value="" id="cod_interno" placeholder="E2801105200071152C320983" required>
      <span class="text-danger">{{$errors->first('Cod_interno')}}</span>
    </div>
    <div class="form-group col-md-6">
      <label>EPC</label>
      <input type="text" class="form-control" name="EPC" value="" id="EPC" placeholder="190000000001ABEA" required>
      <span class="text-danger">{{$errors->first('EPC')}}</span>
    </div>
    <div class="form-group col-md-6">
      <label >Patente Asignada</label>
    <input type="text" class="form-control" name="patente" value=""  id="patente" {{-- pattern="(0[0-9]|1[0-9]|2[0-3])(:[0-5][0-9]){2}-(0[0-9]|1[0-9]|2[0-3])(:[0-5][0-9]){2}" --}} title="Cantidad minima de caracteres es 4, no se permiten caracteres especiales" placeholder="NY8172" >
      <span class="text-danger">{{$errors->first('patente')}}</span>
    </div>
    <div class="form-group col-md-6">
      <label >Estado</label>
      <select class="form-control" name="estado"   id="estado" >
      <option value="1">Grabada</option>
      <option value="2">No Asignada</option>      
    </select>
    
      <span class="text-danger">{{$errors->first('Estado')}}</span>
    </div>
    
  
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