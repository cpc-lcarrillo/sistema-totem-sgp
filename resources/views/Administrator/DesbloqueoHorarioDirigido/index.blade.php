@extends('Administrator.template.layout')

<style type="text/css">
  button {
 color: #f8f9fc00;
    background-color: #f8f9fc00;
    border: 1px solid #f8f9fc00;
    border-top: 1px solid #f8f9fc00;
    border-left: 1px solid #f8f9fc00;
}

button {
  width: auto; /* ie */
  overflow: visible; /* ie */
  padding: 3px 8px 2px 6px; /* ie */
}

button[type] {
  padding: 4px 8px 4px 6px; /* firefox */
}
</style>

@section('content')
          <!-- Page Heading -->

        	
		<!-- <div class="card-body"> -->
        @if (Session::has('message'))
      <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif 
      
<div class="card shadow mb-4">
<div class="card-header py-3">
  <p class="text-right">
  <a href="{{route('DesbloqueoHorarioDirigido.create') }}" class="btn btn-primary ">Agregar Horario Dirigido</a></p>
              <h5 class="m-0 font-weight-bold text-primary">Bloqueo/Desbloqueo Horario Dirigido</h5>
            </div>
            <div class="table-responsive-lg"> <br>
<table class="table table-hover" id="dataTable"  >
  <thead class="thead-dark">
    
    	<tr>
      <th scope="col">#</th>
      <th scope="col">Fecha</th>
      <th scope="col">Hora Inicio</th>
      <th scope="col">Hora Fin</th>
      <th scope="col">Activa /  Desactiva Bloqueo</th>
      <th scope="col">Acciones</th>
    </tr>
    
  </thead>
  <tbody>
    @php
    $id=1;
    @endphp
  	@foreach($DesbloqueoHorarioDirigido as $bloqueohorario)
    
    <tr>
      <th scope="row">{{$id++}}</th>     
      <td>{{$bloqueohorario->fecha_bloq_horario}}</td>
      <td>{{$bloqueohorario->hora_inicio_bloq_horario}}</td>
      <td>{{$bloqueohorario->hora_fin_bloq_horario}}</td>
      <td>
        @if($bloqueohorario->activa_bloqueo_bloq_horario == 1)
        <i class="fa fa-circle text-primary " aria-hidden="true" style='font-size:20px'></i> Totem Bloqueado
        @else
        <i class="fa fa-circle text-success " aria-hidden="true" style='font-size:20px'></i> Totem Desbloqueado 
        @endif
       
        
    </td>
      <td><form action="{{route('DesbloqueoHorarioDirigido.destroy',$bloqueohorario->id_bloq_horario)}}" method="POST">
      @csrf
      @method('DELETE')
        <button type="submit" onclick="return confirm('Está seguro de eliminar {{$bloqueohorario->id_bloq_horario}}')">><i class='fas fa-trash text-success' style='font-size:20px'></i></button>   
      </form>     
      </td>
     
       
      </tr> 
   @endforeach
  </tbody>
</table>


</div>
</dir>
</div>

<!-- </div> -->

<script>
$(document).ready(function() {
  $('#dataTable').DataTable({
    
   "lengthMenu": [ 5, 10, 15, 20, 25 ,30],
       
        
    "language": {
      "url": "../js/datatable/Spanish.json",
      
      
            }
  });
});


</script>



<script src="{{asset('js/demo/datatables-demo.js')}}"></script>
@endsection

