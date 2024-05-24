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
  <div class="ml-10" >
    <form action="{{ route('Atendidos-por-Agentes.store') }}" method="POST">
  @csrf
  <div class="form-group row">
    <label for="staticEmail" class="col-sm-1 col-form-label">Email</label>
    <div class="col-sm-3">
      <select class="form-control" name="id_agente" >         
        @if($id_agente = session('id_agente') == '')
        @else
        <option value="{{ $id_agente = session('id_agente') }}" selected="">{{ $nombre_agente = session('nombre_agente') }}</option>
        <option disabled="">--seleccione una opcion--</option>
        @endif
        
        
        @foreach($agentes as $listAgentes)

      <option value="{{ $listAgentes->id }}">{{ $listAgentes->nombre }}</option>
      @endforeach
      
    </select>
    </div>
    <div class="col-sm-5">
    <button type="submit" class="btn btn-primary">Buscar</button>

    </div>
  </div> 
   
</form>
  </div>
 {{--  <p class="text-right">
    
  <a href="{{route('Atendidos-por-Agentes.create') }}" class="btn btn-primary ">Agregar usuarios</a>
</p>  --}}
              <h5 class="m-0 font-weight-bold text-primary">Reporte Atendidos por Agentes</h5>
            </div>
            <div class="table-responsive-lg"> <br>
<table class="table table-hover" id="dataTable"  >
  <thead class="thead-dark">
    
    	<tr>
      <th scope="col">#</th>
      <th scope="col">Agente</th>
      <th scope="col">Misión</th>
      <th scope="col">Ventanilla</th>
      <th scope="col">Numero de Atención</th>
      <th scope="col">Aco</th>
      <th scope="col">F.Ingreso</th>
      <th scope="col">F.Inicio Atención</th>
      <th scope="col">F.Fin Atención</th>            
      {{-- <th scope="col">Acciones</th> --}}
    </tr>
    
  </thead>
  <tbody>
    @php
    $id=1;
    @endphp
  	@foreach($ReportTAtendidos as $TAtendidos)
    
    <tr>
      <th scope="row">{{$id++}}</th>     
      <td>{{$TAtendidos->usuario}}</td>
      <td>{{$TAtendidos->mision}}</td>
      <td>{{$TAtendidos->ventanilla}}</td>
      <td>{{$TAtendidos->numero_atencion}}</td>
      <td>{{$TAtendidos->ACO}}</td>
      <td>{{$TAtendidos->fecha_ingreso}}</td>
      <td>{{$TAtendidos->fecha_inicio_atencion}}</td>
      <td>{{$TAtendidos->fecha_finalizacion}}</td>      
      

      {{-- <td><form action="{{route('Users.destroy',$usuario->id_usuario)}}" method="POST">
      @csrf
      @method('DELETE')
        <a href="{{ route('Users.edit' , $usuario->id_usuario)}}" ><i class='fas fa-edit text-success'style='font-size:20px'></i></a><button type="submit" onclick="return confirm('esta seguro de eliminar {{$usuario->usuario}}')">><i class='fas fa-trash text-success' style='font-size:20px'></i></button>   
      </form>     
      </td> --}}
     
       
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

