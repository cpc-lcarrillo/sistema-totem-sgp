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
   
    <h5 class="m-0 font-weight-bold text-primary">Reporte números en espera</h5>

  </div>
 {{--  <p class="text-right">
    
  <a href="{{route('Atendidos-por-Agentes.create') }}" class="btn btn-primary ">Agregar usuarios</a>
</p>  --}}
    <div class="table-responsive-lg"> <br>
<table class="table table-hover" id="dataTable"  >
  <thead class="thead-dark">
    
      <tr>
      <th scope="col">#</th>
      <th scope="col">Patente </th>
      <th scope="col">Folio</th>
      <th scope="col">Mision</th>
      <th scope="col">Fecha</th>
      <th scope="col">Número Atención</th>
    
    </tr>
    
  </thead>
  <tbody>
    @php
    $id=1;
    @endphp
    @foreach($reporte_numerosespera as $numerosespera)
    
    <tr>
      <th scope="row">{{$id++}}</th>     
      <td>{{$numerosespera->patente}}</td>
      <td>{{$numerosespera->folio}}</td>
      <td>{{$numerosespera->nombre}}</td>
      <td>{{$numerosespera->fecha_creacion}}</td>       
      <td>{{$numerosespera->numero_atencion}}</td>       
   
     
       
      </tr> 
   @endforeach
  </tbody>
</table>


</div>          
            
           

</div>

<!-- </div> -->

<script>
$(document).ready(function() {
  $('#dataTable').DataTable({
    
   "lengthMenu": [ 30,25,20,15,10,5],
       
        
    "language": {
      "url": "../js/datatable/Spanish.json",
      
      
            }
  });
});


</script>



<script src="{{asset('js/demo/datatables-demo.js')}}"></script>
@endsection

