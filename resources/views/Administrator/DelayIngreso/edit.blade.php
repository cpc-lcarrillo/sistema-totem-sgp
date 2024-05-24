@extends('Administrator.template.layout')

@section('content')
<h1 class="h3 mb-5 text-gray-800 ">Editar Delay</h1>
<div class="card mb-4 py-3 border-bottom-primary">
<div class="container">


<form action="{{ route('DelayIngreso.update', $DelayIngreso->id) }}" method="POST">
  @csrf
  @method('PUT')   
 
  <div class="form-row">
    <div class="form-group col-md-6">
      <label f>Delay Inicio</label>
      <input type="text" class="form-control" name="Delay_Inicio" value="{{$DelayIngreso->Delay_Inicio}}" id="Delay_Inicio" placeholder="10" required>
      <span class="text-danger">{{$errors->first('Delay_Inicio')}}</span>
    </div>
    <div class="form-group col-md-6">
      <label>Delay Fin</label>
      <input type="text" class="form-control" name="Delay_Fin" value="{{$DelayIngreso->Delay_Fin}}" id="Delay_Fin" placeholder="10" required>
      <span class="text-danger">{{$errors->first('Delay_Fin')}}</span>
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
