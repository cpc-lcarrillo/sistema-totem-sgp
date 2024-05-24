@extends('Administrator.template.layout')

@section('content')
<h1 class="h3 mb-5 text-gray-800 ">Editar Misión</h1>
<div class="card mb-4 py-3 border-bottom-primary">
<div class="container">


<form action="{{ route('Misiones.update', $listarmision->id) }}" method="POST">
  @csrf
  @method('PUT')   
 
  <div class="form-row">
      
    <div class="form-group col-md-6">
      <label >Nombre</label>
      <input type="text" class="form-control" name="nombre" value="{{$listarmision->nombre}}"  id="nombre" placeholder="Nombre de misión" required>
      <span class="text-danger">{{$errors->first('nombre')}}</span>
    </div>
    <div class="form-group col-md-6">
      <label>Tipo de mision</label>
      <select class="form-control" name="tipo_mision" id="tipo_mision" disabled>
        <option value="0" @if($listarmision->mision_puerto == 0) selected @endif>Deposito-Atencion-General</option>
        <option value="1" @if($listarmision->mision_puerto == 1) selected @endif>Retiro Contenedor Full</option>
        <option value="2" @if($listarmision->mision_puerto == 2) selected @endif>Retiro Contenedor Vacio</option>
        <option value="3" @if($listarmision->mision_puerto == 3) selected @endif>Entrega Contenedor Full</option>
        <option value="4" @if($listarmision->mision_puerto == 4) selected @endif>Entrega Contenedor Vacio</option>
      </select>  
      <span class="text-danger">{{$errors->first('tipo_mision')}}</span>
    </div>
     <div class="form-group col-md-6">
      <label>Tipo de contenedor</label>
      <select class="form-control" name="tipo_contenedor" id="tipo_contenedor">
        <option value="">Sin tipo de contenedor</option>
        <option value="Dry" @if($listarmision->tipo_contenedor === 'Dry') selected @endif>Dry</option>
        <option value="Refeer" @if($listarmision->tipo_contenedor === 'Refeer') selected @endif>Refeer</option> 
      </select>
  
      <span class="text-danger">{{$errors->first('tipo_contenedor')}}</span>
    </div>
    <div class="form-group col-md-6">
      <label>Horario</label>
      <select class="form-control" name="horario" id="horario">
        <option value="" @if($listarmision->horario === '') selected @endif>Sin horario</option>
        <option value="Bloque" @if($listarmision->horario === 'Bloque') selected @endif>Bloque</option>
        <option value="Fuera" @if($listarmision->horario === 'Fuera') selected @endif>Fuera</option>
    </select>

      <span class="text-danger">{{$errors->first('horario')}}</span>
    </div>


   <div class="form-group col-md-6">
      <label for="inputEmail4">Letra Ticket</label>
      <input type="text" class="form-control" name="letra_ticket" id="dv" placeholder="letra Ticket" value="{{$listarmision->letra_ticket}}" maxlength="4" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required="">
      <span class="text-danger">{{$errors->first('letra_ticket')}}</span>
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
