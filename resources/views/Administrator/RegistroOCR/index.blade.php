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
  <div class="ml-10">
    @php
    $error = DB::table('AdminOCR')->first();

    //return $listarusuarios->error_txt;
    @endphp
    <form action="{{ route('RegistroOCR.update', '1') }}" method="POST">
      @csrf
      @method('PUT')  
    <div class="form-group row">
    <label for="staticEmail" class="col-sm-1 col-form-label">Error </label>
    <div class="col-sm-6">
      <input type="txt" class="form-control" name="error_txt" value="{{$error->error_txt}}" id="error_txt" placeholder="Error totem" required>
    </div>
    <div class="col-sm-2">
    <button type="submit" class="btn btn-warning">Guardar</button>

    </div>
  </div> 
   
</form>
  </div>
  <p class="text-right">
    
  <a href="{{route('RegistroOCR.create') }}" class="btn btn-primary ">Agregar Registro OCR</a></p>
              <h5 class="m-0 font-weight-bold text-primary">Registros OCR</h5>
            </div>
            <div class="table-responsive-lg"> <br>
<table class="table table-hover" id="dataTable"  >
  <thead class="thead-dark">
    
    	<tr>
      <th scope="col">#</th>
      <th scope="col">fechaIngreso</th>
      <th scope="col">horaIngreso</th>
      <th scope="col">patenteTransporte</th>
      <th scope="col">statusEmision</th> 
      <th scope="col">generacionRegistro</th>
      <th scope="col">FechaCreacion</th>            
      <th scope="col">Acciones</th>
    </tr>
    
  </thead>
  <tbody>
    @php
    $id=1;
    @endphp
  	@foreach($controlEmisionTicket as $OCREmision)
    
    <tr>
      <th scope="row">{{$id++}}</th>     
      <td>{{$OCREmision->fechaIngreso}}</td>
      <td>{{$OCREmision->horaIngreso}}</td>
      <td>{{$OCREmision->patenteTransporte}}</td>      
      <td>{{$OCREmision->statusEmision}}</td>      
      <td>{{$OCREmision->generacionRegistro}}</td>
      <td>{{$OCREmision->fechaEmision}}</td>            
      <td><form action="{{route('RegistroOCR.destroy',$OCREmision->idControlEmisionTicket)}}" method="POST">
      @csrf
      @method('DELETE')
        <button type="submit" onclick="return confirm('esta seguro de eliminar {{$OCREmision->idControlEmisionTicket}}')">><i class='fas fa-trash text-success' style='font-size:20px'></i></button>   
      </form>     
      </td>
     
       
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
    
   "lengthMenu": [ 30, 60, 90,120,150],
       
        
    "language": {
      "url": "../js/datatable/Spanish.json",
      
      
            }
  });
});


</script>



<script src="{{asset('js/demo/datatables-demo.js')}}"></script>
@endsection

