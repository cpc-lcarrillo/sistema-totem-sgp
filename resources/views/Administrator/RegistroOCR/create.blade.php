@extends('Administrator.template.layout')

@section('content')


          <!-- Page Heading -->
<h1 class="h3 mb-5 text-gray-800 ">Agregar Registro OCR</h1>
<div class="card mb-4 py-3 border-bottom-primary">

<div class="container-fluid">
<form action="{{ route('RegistroOCR.store') }}" method="POST">
  @csrf

  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Patente</label>
      <input type="text" class="form-control" name="PatenteTransporte"  id="PatenteTransporte" placeholder="XX7406" maxlength="8" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required>
      <span class="text-danger">{{$errors->first('PatenteTransporte')}}</span>
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