<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

<style>
body {
    color: #000;
    overflow-x: hidden;
    height: 100%;
    background-color: #044d6d;
    background-repeat: no-repeat
}

.card {
    z-index: 0;
    background-color: #ECEFF1;
    padding-bottom: 20px;
    margin-top: 90px;
    margin-bottom: 90px;
    border-radius: 10px
}

.top {
    padding-top: 40px;
    padding-left: 13% !important;
    padding-right: 13% !important
}

#progressbar {
    margin-bottom: 0px;
    overflow: hidden;
    color: #455A64;
    padding-left: 0px;
    margin-top: 30px
}

#progressbar li {
    list-style-type: none;
    font-size: 13px;
    width: 16%;
    float: left;
    position: relative;
    font-weight: 400
}

#progressbar .step0:before {
    font-family: FontAwesome;
    content: "\f10c";
    color: #fff
}

#progressbar li:before {
    width: 40px;
    height: 40px;
    line-height: 45px;
    display: block;
    font-size: 20px;
    background: #C5CAE9;
    border-radius: 50%;
    margin: auto;
    padding: 0px
}

#progressbar li:after {
    content: '';
    width: 100%;
    height: 12px;
    background: #C5CAE9;
    position: absolute;
    left: 0;
    top: 16px;
    z-index: -1
}

#progressbar li:last-child:after {
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;
    position: absolute;
    left: -50%
}

#progressbar li:nth-child(2):after,
#progressbar li:nth-child(3):after,
#progressbar li:nth-child(4):after,
#progressbar li:nth-child(5):after {
    left: -50%
}

#progressbar li:first-child:after {
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;
    position: absolute;
    left: 50%
}

#progressbar li:last-child:after {
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px
}

#progressbar li:first-child:after {
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px
}

#progressbar li.active:before,
#progressbar li.active:after {
    background: #f28200
}

#progressbar li.active:before {
    font-family: FontAwesome;
    content: "\f00c"
}

.icon {
    width: 50px;
    height: 50px;
    margin-right: 5px
}

.icon-content {
    padding-bottom: 20px
}

@media screen and (max-width: 100%) {
    .icon-content {
        width: 100%
    }
}</style>
                                <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
                                <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
                                <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
                                <script type="text/javascript"></script>


</head>
<body>
	
<div class="container px-8 px-md-6 py-5 mx-auto">
    <div class="card">
        <div class="row d-flex justify-content-between px-3 top">
            <div class="d-flex">
                <h5>PATENTE <span class="text-primary font-weight-bold">{{$Patente}}</span></h5>
                <span class="text-primary font-weight-bold">&nbsp;</span> 
                {{-- <h5>FOLIO <span class="text-primary font-weight-bold">228370</span></h5> --}}
                
            </div>
            <div class="d-flex flex-column text-sm-right">
                <p class="mb-0">Fecha de consulta <span>{{$fecha_Ingreso}} Hrs</span></p>
                <!-- <p>USPS <span class="font-weight-bold">234094567242423422898</span></p> -->
            </div>
        </div> <!-- Add class 'active' to progress -->
        <div class="row d-flex justify-content-center">
            <div class="col-12">
                <ul id="progressbar" class="text-center">
                	{{-- @switch($i)
    				@case(1)
			        First case...
			        @break

			    	@case(2)
			        Second case...
			        @break

			    	@default
			       <p class="font-weight-bold">NO SE ENCONTRARON REGISTROS</p>
					@endswitch --}}


@foreach($ubicacion AS $ubicaciones)
					@switch($ubicaciones->id_ubicacion)
    				@case(1)
			        <li class="active step0">
                    	<p class="font-weight-bold">{{$ubicaciones->nombre_ubicacion}}<br> {{$ubicaciones->fecha_update}}</p>

                    	<img class="icon" src="https://image.flaticon.com/icons/svg/1465/1465185.svg">
                    </li>
			        @break

			    	@case(2)
			        <li class="active step0">
                    	<p class="font-weight-bold">{{$ubicaciones->nombre_ubicacion}}<br> {{$ubicaciones->fecha_update}}</p>
                    	<img class="icon" src="https://image.flaticon.com/icons/svg/1465/1465185.svg">
                    </li>
			        @break

			        @case(3)
			       <li class="active step0">
                        <p class="font-weight-bold">{{$ubicaciones->nombre_ubicacion}}<br> {{$ubicaciones->fecha_update}}</p>
                    	<img class="icon" src="https://image.flaticon.com/icons/svg/1465/1465185.svg">

                    </li>
			        @break

			        @case(4)
			       
                    <li class="active step0">
                    	<p class="font-weight-bold">{{$ubicaciones->nombre_ubicacion}}<br> {{$ubicaciones->fecha_update}}</p>
                    	<img class="icon" src="https://image.flaticon.com/icons/svg/1465/1465185.svg">
                    </li>
			        @break

			        @case(5)
			        <li class="active step0">
                    	<p class="font-weight-bold">{{$ubicaciones->nombre_ubicacion}}<br> {{$ubicaciones->fecha_update}}</p>
                    	<img class="icon" src="https://image.flaticon.com/icons/svg/1465/1465185.svg">
                    </li>
			        @break
                     @case(6)
                    <li class="active step0">
                        <p class="font-weight-bold">{{$ubicaciones->nombre_ubicacion}}<br> {{$ubicaciones->fecha_update}}</p>
                        <img class="icon" src="https://image.flaticon.com/icons/svg/1465/1465185.svg">
                    </li>
                    @break
                     @case(7)
                    <li class="active step0">
                        <p class="font-weight-bold">{{$ubicaciones->nombre_ubicacion}}<br> {{$ubicaciones->fecha_update}}</p>
                        <img class="icon" src="https://image.flaticon.com/icons/svg/1465/1465185.svg">
                    </li>
                    @break
                     @case(8)
                    <li class="active step0">
                        <p class="font-weight-bold">{{$ubicaciones->nombre_ubicacion}}<br> {{$ubicaciones->fecha_update}}</p>
                        <img class="icon" src="https://image.flaticon.com/icons/svg/1465/1465185.svg">
                    </li>
                    @break
                     @case(9)
                    <li class="active step0">
                        <p class="font-weight-bold">{{$ubicaciones->nombre_ubicacion}}<br> {{$ubicaciones->fecha_update}}</p>
                        <img class="icon" src="https://image.flaticon.com/icons/svg/1465/1465185.svg">
                    </li>
                    @break
                     @case(10)
                    <li class="active step0">
                        <p class="font-weight-bold">{{$ubicaciones->nombre_ubicacion}}<br> {{$ubicaciones->fecha_update}}</p>
                        <img class="icon" src="https://image.flaticon.com/icons/svg/1465/1465185.svg">
                    </li>
                    @break
                    @case(11)
                    <li class="active step0">
                        <p class="font-weight-bold">{{$ubicaciones->nombre_ubicacion}}<br> {{$ubicaciones->fecha_update}}</p>
                        <img class="icon" src="https://image.flaticon.com/icons/svg/950/950299.svg">
                    </li>
                    @break
                    @case(12)
                    <li class="active step0">
                        <p class="font-weight-bold">{{$ubicaciones->nombre_ubicacion}}<br> {{$ubicaciones->fecha_update}}</p>
                        <img class="icon" src="https://image.flaticon.com/icons/svg/3135/3135663.svg">
                    </li>
                    @break
                    @case(13)
                    <li class="active step0">
                        <p class="font-weight-bold">{{$ubicaciones->nombre_ubicacion}}<br> {{$ubicaciones->fecha_update}}</p>
                        <img class="icon" src="../img/logistica.svg">
                    </li>
                    @break
                    @case(14)
                    <li class="active step0">
                        <p class="font-weight-bold">{{$ubicaciones->nombre_ubicacion}}<br> {{$ubicaciones->fecha_update}}</p>
                        <img class="icon" src="../img/almacen.svg">
                    </li>
                    @break
                    
                    @default
                    <li class="active step0">
                    </li>
			    	{{-- @if($ubicaciones->ubicacion == NULL)
			    		<p class="font-weight-bold">NO SE ENCONTRARON DATOS</p>
			    	@else --}}
			       
                    {{-- @endif --}}
					@endswitch


                    
@endforeach()                    
                    
                    
                    
                </ul>
            </div>
        </div>
       {{--  <div class="row justify-content-between top">
            <div class="row d-flex icon-content"> <img class="icon" src="https://image.flaticon.com/icons/svg/1465/1465185.svg">
                <div class="d-flex flex-column">
                    <p class="font-weight-bold">Punto 1<br>Ingreso CLC</p>
                </div>
            </div>
            <div class="row d-flex icon-content"> <img class="icon" src="https://image.flaticon.com/icons/svg/3135/3135663.svg">
                <div class="d-flex flex-column">
                    <p class="font-weight-bold">Punto 2<br>Capturador</p>
                </div>
            </div>
            <div class="row d-flex icon-content"> <img class="icon" src="https://image.flaticon.com/icons/svg/950/950299.svg">
                <div class="d-flex flex-column">
                    <p class="font-weight-bold">Punto 3<br>Ventanilla Totem</p>
                </div>
            </div>
            <div class="row d-flex icon-content"> <img class="icon" src="https://i.imgur.com/TkPm63y.png">
                <div class="d-flex flex-column">
                    <p class="font-weight-bold">Punto 4<br>Operaciones Internas</p>
                </div>
            </div>
            <div class="row d-flex icon-content"> <img class="icon" src="https://image.flaticon.com/icons/svg/1465/1465185.svg">
                <div class="d-flex flex-column">
                    <p class="font-weight-bold">Punto 5<br>Salida CLC</p>
                </div>
            </div>
            
        </div> --}}
        <br><br><br>
  <div class="d-flex justify-content-center p-2">
     {{-- <a href="../Transportista" class="btn btn-lg  btn-primary ">Volver</a> --}}

     <a href="{{ URL::previous() }}" class="btn btn-lg  btn-primary ">Volver</a>
     

  </div>

    </div>
</div>


</body>
</html>

