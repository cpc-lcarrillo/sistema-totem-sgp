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
  <a href="{{route('Misiones.create') }}" class="btn btn-primary ">Agregar Misión</a></p>
              <h5 class="m-0 font-weight-bold text-primary">Misiones</h5>
            </div>
            <div class="table-responsive-lg"> <br>
<table class="table table-hover" id="dataTable"  >
  <thead class="thead-dark">
    
    	<tr>
      <th scope="col">#</th>
      <th scope="col">Nombre</th>
      <th scope="col">Tipo Contenedor</th>
      <th scope="col">Letra</th>    
      <th scope="col">Horario</th>  
      <th scope="col">Acciones</th>
    </tr>
    
  </thead>
  <tbody>
    @php
    $id=1;
    @endphp
  	@foreach($listaMisiones as $Lmisiones)
    
    <tr>
      <th scope="row">{{$id++}}</th>     
      <td>{{$Lmisiones->nombre}}</td>
      <td>{{$Lmisiones->tipo_contenedor}}</td>      
      <td>{{$Lmisiones->letra_ticket}}</td>      
      <td>{{$Lmisiones->horario}}</td>
            
      <td><form action="{{route('Misiones.destroy',$Lmisiones->id)}}" method="POST">
      @csrf
      @method('DELETE')
        <a href="{{ route('Misiones.edit' , $Lmisiones->id)}}" ><i class='fas fa-edit text-success'style='font-size:20px'></i></a><button type="submit" onclick="return confirm('esta seguro de eliminar {{$Lmisiones->nombre}}')">><i class='fas fa-trash text-success' style='font-size:20px'></i></button>   
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
    
   "lengthMenu": [ 15, 20, 25 ,30],
       
        
    "language": {
      "url": "../js/datatable/Spanish.json",
      
      
            }
  });
});


</script>



<script src="{{asset('js/demo/datatables-demo.js')}}"></script>
@endsection

