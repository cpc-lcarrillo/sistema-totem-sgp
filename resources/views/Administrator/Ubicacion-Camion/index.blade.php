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
<title>TAG</title>
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
              <h5 class="m-0 font-weight-bold text-primary">Ubicación Camión</h5>
            </div>
            <div class="table-responsive-lg"> <br>
<table class="table table-hover" id="dataTable"  >
  <thead class="thead-dark">
    
    	<tr>
      <th scope="col">#</th>
      <th scope="col">Patente</th>
      <th scope="col">EPC</th>
      <th scope="col">Punto1</th>
      <th scope="col">Punto2</th>
      <th scope="col">Punto3</th>
      <th scope="col">Punto4</th>
      <th scope="col">Punto5</th>
      <th scope="col">Punto6</th>
      <th scope="col">Punto7</th>
      <th scope="col">Punto8</th>
      <th scope="col">Punto9</th>
      <th scope="col">Punto10</th>
      <th scope="col">Ubicación</th>
    </tr>
    
  </thead>
  <tbody>
    @php
    $id=1;
    @endphp
  	@foreach($UbicacionCamion as $Camion)
    
    <tr>
      <th scope="row">{{$id++}}</th> 
      <td>{{$Camion->patente}}</td>    
      <td>{{$Camion->EPC}}</td>
      <td>{{$Camion->punto1}}</td>
      <td>{{$Camion->punto2}}</td>
      <td>{{$Camion->punto3}}</td>
      <td>{{$Camion->punto4}}</td>
      <td>{{$Camion->punto5}}</td>
      <td>{{$Camion->punto6}}</td>
      <td>{{$Camion->punto7}}</td>
      <td>{{$Camion->punto8}}</td>
      <td>{{$Camion->punto9}}</td>
      <td>{{$Camion->punto10}}</td>    
       
      
      <td><form action="{{route('Transportista.update',1)}}" method="POST">
        <input type="hidden"  class="form-control" name="patente" value="{{$Camion->patente}}">
      @csrf
      @method('PUT') 
        <button type="submit" onclick="return confirm('Esta seguro de salir de la pagina {{$Camion->patente}}')">><i class='fas fa-location-arrow text-success' style='font-size:20px'></i></button>   
      </form>     
      </td>
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

