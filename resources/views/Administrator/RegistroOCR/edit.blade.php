@extends('Administrator.template.layout')

@section('content')
<h1 class="h3 mb-5 text-gray-800 ">Editar usuarios</h1>
<div class="card mb-4 py-3 border-bottom-primary">
<div class="container">


<form action="{{ route('RegistroOCR.update', '1') }}" method="POST">
  @csrf
  @method('PUT')   
 
  <div class="form-row">
    <div class="form-group col-md-6">
      <label f>Usuario</label>
      <input type="txt" class="form-control" name="error_txt" value="error_txt" id="error_txt" placeholder="Error Totem" required>
      <span class="text-danger">{{$errors->first('Usuario')}}</span>
    </div>
    
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