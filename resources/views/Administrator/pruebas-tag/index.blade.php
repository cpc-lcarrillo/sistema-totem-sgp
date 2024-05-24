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
<title>Prueba TAG</title>
@section('content')
          <!-- Page Heading -->

        	
		<!-- <div class="card-body"> -->
        @if (Session::has('message'))
      <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif 
      
<div class="card shadow mb-4">
<div class="card-header py-3">
  <p class="text-right">
  {{-- <a href="{{route('Tag.create') }}" class="btn btn-primary ">Agregar nuevo TAG</a></p> --}}
              <h5 class="m-0 font-weight-bold text-primary">Pruebas Tag</h5>
            </div>
            <div class="table-responsive-lg"> <br>
<table class="table table-hover" id="dataTable"  >
  <thead class="thead-dark">
    
    	<tr>
      <th scope="col">#</th>
      <th scope="col">IdReader</th>
      <th scope="col">fecha Primera Lectura</th>
      <th scope="col">fecha ultima lectura</th>
      <th scope="col">Reader IP</th>
      <th scope="col">N°Antena</th>
      <th scope="col">Nombre</th>
      
    </tr>
    
  </thead>
  <tbody>
    @php
    $id=1;
    @endphp
  	@foreach($PruebasTag as $TagPruebas)
    
    <tr>
      <th scope="row">{{$id++}}</th> 
      <td>{{$TagPruebas->id_reader}}</td>    
      <td>{{$TagPruebas->fecha_primera_lectura}}</td>
      <td>{{$TagPruebas->fecha_ultima_lectura}}</td>
      <td>{{$TagPruebas->reader_ip}}</td>
      <td>{{$TagPruebas->NAntena}}</td>
      <td>{{$TagPruebas->nombre}}</td>
          
       
      
      
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

