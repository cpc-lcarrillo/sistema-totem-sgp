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
  <!-- <a href="{{route('Users.create') }}" class="btn btn-primary ">Agregar usuarios</a></p> -->
              <h5 class="m-0 font-weight-bold text-primary">Agentes Ventanillas</h5>
            </div>
            <div class="table-responsive-lg"> <br>
<table class="table table-hover" id="dataTable"  >
  <thead class="thead-dark">
    
    	<tr>
      <th scope="col">#</th>
      <th scope="col">NombreAgente</th>
      <th scope="col">Ventanilla</th>            
      <th scope="col">Acciones</th>
    </tr>
    
  </thead>
  <tbody>
    @php
    $id=1;
    @endphp
  	@foreach($AgentesVentana as $AgentesVentanas)
    
    <tr>
      <th scope="row">{{$AgentesVentanas->id}}</th>     
      <td>{{$AgentesVentanas->nombre_agente}}</td>
      <td>{{$AgentesVentanas->nombre_ventanilla}}</td>
           
      <td><form action="{{route('AgentesVentana.destroy',$AgentesVentanas->id)}}" method="POST">
      @csrf
      @method('DELETE')
        <a href="{{ route('AgentesVentana.edit' , $AgentesVentanas->id)}}" ><i class='fas fa-edit text-success'style='font-size:20px'></i></a><button type="submit" onclick="return confirm('esta seguro de eliminar {{$usuario->usuario}}')">><i class='fas fa-trash text-success' style='font-size:20px'></i></button>   
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

