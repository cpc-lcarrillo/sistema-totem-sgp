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
  {{-- <a href="{{route('Users.create') }}" class="btn btn-primary ">Agregar usuarios</a></p> --}}
              <h5 class="m-0 font-weight-bold text-primary">Estado Sistema OCR</h5>
            </div>
            <div class="table-responsive-lg"> <br>
<table class="table table-hover" id="dataTable"  >
  <thead class="thead-dark">
    
    	<tr>
      <th scope="col">#</th>
      <th scope="col">Activo</th>
      <th scope="col">Accione</th>
      
    </tr>
    
  </thead>
  <tbody>
    @php
    $id=1;
    @endphp
   
  	@foreach($EstadoOCR as $estado)
    
    <tr>
      <th scope="row">EstadoOCR</th>     
      <td>
      <form action="{{ route('Ocr.store') }}" method="POST">
  @csrf
      <select name="ActivoOCR" class="form-select" aria-label="Default select example">
  @if($estado->estado_actividad == 1)
  <option value="{{$estado->estado_actividad}}">SI</option>
  <option value="0">NO</option>
  
  @else
  <option value="{{$estado->estado_actividad}}">NO</option>
  <option value="1">SI</option>

  @endif
  
</select>
        
      </td>
      <td><button type="submit" onclick="return confirm('Está segur@ de modificar Estado OCR ')" ><i class='fas fa-save text-success' style='font-size:20px'></i></button></td>
      </form>
       
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
    
   "lengthMenu": [ 5, 10, 15, 20, 25 ,30],
       
        
    "language": {
      "url": "../js/datatable/Spanish.json",
      
      
            }
  });
});


</script>



<script src="{{asset('js/demo/datatables-demo.js')}}"></script>
@endsection

