@extends('Administrator.template.layout')

@section('content')


          <!-- Page Heading -->
<h1 class="h3 mb-5 text-gray-800 ">Agregar Distribución</h1>
<div class="card mb-4 py-3 border-bottom-primary">

<div class="container-fluid">
<form action="{{ route('Distribucion.store') }}" method="POST">
  @csrf

  <div class="form-row">
     <div class="form-group col-md-6">
    <label for="exampleFormControlSelect1">Ventanilla</label>
    <select class="form-control" id="id_ventana" name="id_ventana" required title="Ventanilla">
      <option value="" selected disabled="">Seleccione una ventanilla</option>
      @foreach($ventanas as $ventana)
      <option value="{{$ventana->id}}">{{$ventana->nombre}}</option>
      @endforeach           
    </select>
    <span class="text-danger">{{$errors->first('id_ventana')}}</span>
  </div> 
     <div class="form-group col-md-6">
    <label for="exampleFormControlSelect1">Misión</label>
    <select class="form-control" id="id_mision" name="id_mision" required title="Misión">
      <option value="" selected disabled="">Seleccione una ventanilla</option>
      @foreach($misiones as $mision)
      <option value="{{$mision->id}}">{{$mision->nombre}}</option>
      @endforeach           
    </select>
    <span class="text-danger">{{$errors->first('id_mision')}}</span>
  </div> 
    

    <div class="form-group col-md-3">
      <label for="inputEmail4">Prioridad</label>
     <select class="form-control" id="prioridad" name="prioridad" required>
     <option value="" selected disabled="">Seleccione una Prioridad</option>
       @for ($i = 1; $i < 11; $i++)
    The current value is {{ $i }}
     <option value="{{ $i }}">{{ $i }}</option>
        @endfor    
    </select>
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