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
  <a href="{{route('Tag.create') }}" class="btn btn-primary ">Agregar nuevo TAG</a></p>
              <h5 class="m-0 font-weight-bold text-primary">Tags</h5>
            </div>
            <div class="table-responsive-lg"> <br>
<table class="table table-hover" id="dataTable"  >
  <thead class="thead-dark">
    
    	<tr>
      <th scope="col">#</th>
      <th scope="col">Cod.Interno</th>
      <th scope="col">EPC</th>
      <th scope="col">Patente Asignada</th>
      <th scope="col">Estado</th>
        
      <th scope="col">Acciones</th>
    </tr>
    
  </thead>
  <tbody>
    @php
    $id=1;
    @endphp
  	@foreach($listaTAG as $Tags)
    
    <tr>
      <th scope="row">{{$id++}}</th> 
      <td>{{$Tags->Cod_interno}}</td>    
      <td>{{$Tags->EPC}}</td>
            
      <td>{{$Tags->patente}}</td> 
      @switch($Tags->Estado)
      @case(1)
      <td class="text-primary">Grabada</td>
      @break
      @case(0)
      <td class="text-success">No Asignada</td>
      @break
      @default        
      @endswitch  
      
      <td><form action="{{route('Tag.destroy',$Tags->id)}}" method="POST">
      @csrf
      @method('DELETE')
        <a href="{{ route('Tag.edit' , $Tags->id)}}" ><i class='fas fa-edit text-success'style='font-size:20px'></i></a><button type="submit" onclick="return confirm('esta seguro de eliminar {{$Tags->id}}')">><i class='fas fa-trash text-success' style='font-size:20px'></i></button>   
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

