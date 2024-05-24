
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  
<link rel="shortcut icon" href="{{asset('img/fondos/favicon.ico')}}">
<link href="{{ asset('css/icon.css')}}"
      rel="stylesheet">     
  
<link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<link rel="stylesheet" href="{{asset('css/all.css')}}" integrity="sha384-6jHF7Z3XI3fF4XZixAuSu0gGKrXwoX/w3uFPxC56OtjChio7wtTGJWRW53Nhx6Ev" crossorigin="anonymous">
  <!-- Custom fonts for this template-->
  
  <link href="{{ asset('css/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
  <link href="h{{ asset('css/fonts.css')}}" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/style-theme.css') }}">
   <script type='text/javascript' src="{{ asset('js/jquery.min.js') }}"></script>
   <link href="{{ asset('css/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
   	<link href="{{asset('jQWidgets/styles/jqx.base.css')}}" rel="stylesheet">
   
   

   
<style>
.body{  
  
  background: url({{ asset('/img/fondos/fondocpc.jpg') }});
   /* Center the image */
  background-repeat: no-repeat;
  height: 100%;
  width: 100%;
}
.bluenav{
  background-color: #7CA4DD;

} 
.bordetop{
 border-top-left-radius:     2em 2em;
 border-top-right-radius:    2em 2em;
  background-color: #7CA4DD;
}
.bodeabajo{
  border-bottom-right-radius: 2em 2em;
border-bottom-left-radius:  2em 2em;
 background-color: #7CA4DD;
}

</style>
   

<body id="page-top" >

  <!-- Page Wrapper -->

  <div id="wrapper" class="body overflow-hidden">

    <!-- Sidebar -->

    <ul class="  navbar-nav body sidebar sidebar-dark accordion  " id="accordionSidebar"  role="tablist">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center my-3  " href="{{route('Menu.index')}}">
         <div class="sidebar-brand-icon"> 
           {{-- <img src="{{asset('img/fondos/logos/coruscall.png')}}" class="img-fluid" > --}}
          <img src="{{asset('/img/logoMenu/logoCPC.png')}}" width="30px" height="30px"> 
        </div>
        <div class="sidebar-brand-text mx-1">
       <img src="{{asset('/img/logoMenu/logoCPC2.png')}}" width="150px" height="30px">
      </div>

        
      </a>

      <!-- Divider -->

      {{-- <hr class="sidebar-divider my-1 " > --}}

{{--       <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" id="MenuPrincipal" href="{{route('menu.index')}}">
          <i class="material-icons">menu</i>
          <span>Menu Principal</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider"> --}}

      <!-- Heading -->
      
      <!-- Nav Item - Pages Collapse Menu -->

      @php
        $int=0;
      $IDEMPRESA = session('id_DBDEM');
        $DBIDT = session('id_DBDT');
        $TIPO=1;        
        $MENU = DB::connection('mysql')->select("CALL sp_buscar_menu($IDEMPRESA,$DBIDT,$TIPO)");
      @endphp
      @foreach ($MENU as $item)
      <li class="{{$item->CLASE_MENU}} bordertop" >
       
      @if($item->URL_MENU=='#')
      <a style="color:#FFF;" class="nav-link collapsed  bordetop" id="{{$item->DETALLE_MENU}}" href="#" data-toggle="collapse" data-target="#collapse{{$item->DETALLE_MENU}}" aria-expanded="true" aria-controls="collapse{{$item->DETALLE_MENU}}">
        <i class="material-icons align-middle" style="color:#FFF;">{{$item->ICONO_MENU}}</i>
        <span > {{$item->DETALLE_MENU}}</span>
      </a>
      @else
      <a style="color:#FFF; " class="nav-link" href="{{route($item->URL_MENU)}}"> 
       
      
        <i class="material-icons align-middle" style="color:#FFF;">{{$item->ICONO_MENU}}</i>
          <span > {{$item->DETALLE_MENU}}</span>
        </a>
        @endif 

        


           <div id="collapse{{$item->DETALLE_MENU}}" class="collapse @if($item->DBIDMENU =='1'){{Request::is('Administrator/Users','Administrator/Misiones','Administrator/Agentes','Administrator/Ventanillas','Administrator/Distribucion') ? 'show' : ''}}@endif @if($item->DBIDMENU =='6'){{Request::is('Administrator/Atendidos-por-Agentes') ? 'show ' : ''}}@endif @if($item->DBIDMENU =='3'){{Request::is('agentes','colasatencion','horarioatencion','excepcionhorariacolas','musiconhold','tipificar','estados','epa') ? 'show ' : ''}}@endif @if($item->DBIDMENU =='4'){{Request::is('pruebatts') ? 'show ' : ''}}@endif" aria-labelledby="heading{{$item->DETALLE_MENU}}" data-parent="#{{$item->DETALLE_MENU}}">


          <div class="bg-white bluenav py-2 collapse-inner rounded">
            <h6 class="collapse-header"> {{$item->DETALLE_MENU}}:</h6>
          
              @php
              $IDEMPRESA = session('id_DBDEM');
              $DBIDT = session('id_DBDT');
              $idMENU=$item->DBIDMENU;
              $TIPO=1;
    

            $SUBMENU = DB::connection('mysql')->select("CALL sp_buscar_sub_menu($IDEMPRESA,$idMENU,$DBIDT,$TIPO)");
            @endphp
            @foreach ($SUBMENU as $Submenu)
            {{-- {{$Submenu->DETALLE_MENU}}<BR> --}}
            {{-- <a class="collapse-item" href="{{route('callbackagente.index')}}" id="DistribucionCallback"><i class="material-icons md-18">device_hub</i> Distribucion Callback</a> --}}
            @if($Submenu->URL_MENU == '#')
            <a class="{{$Submenu->CLASE_MENU}}" href="#"><i  class="material-icons md-18 align-middle">{{$Submenu->ICONO_MENU}}</i>{{$Submenu->DETALLE_MENU}}</a> 
            @else
            <a class="{{$Submenu->CLASE_MENU}}" href="{{route($Submenu->URL_MENU)}}"><i  class="material-icons md-18 align-middle">{{$Submenu->ICONO_MENU}}</i>{{$Submenu->DETALLE_MENU}}</a>  
            @endif
            
            
            @endforeach
          </div>
        </div>
      
     
       <hr class="sidebar-divider d-none d-md-block bluenav">
       
      </li>
         @endforeach
      <!-- Divider -->

    

      <!-- Divider -->
      {{-- <hr class="sidebar-divider d-none d-md-block bluenav"> --}}


      <!-- Sidebar Toggler (Sidebar) -->

      <div class="text-center d-none d-md-inline py-5">

        <button class="rounded-circle border-0 " style="background-color:#7CA4DD; " id="sidebarToggle"></button>
      </div>


    </ul>
    
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
 
      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

         
          <ul class="navbar-nav ml-auto">

             
            <div class="topbar-divider d-none d-sm-block"></div>
 
            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{-- {{@$id_DBDT = session('UserTipo')}} --}}</span>
                <img class="img-profile rounded-circle" src="{{asset('/img/logoMenu/logoCPC.png')}}" width="60px" height="60px">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{-- {{ route('Users.edit' , @$tel = session('DBIDUS'))}} --}}">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>

                  Perfil(
                  @if($DBIDT = session('id_DBDT') == 1)
                  Administrador
                  @else
                  Ventanilla
                  @endif
                  )
                  
                </a>
                
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Salir
                </a>
              </div>
            </li>

          </ul>

        </nav>
       
      <!-- Aqui se consentra el contenido recibido por controlador -->  
      <div class="mb-3 container col-md-12">
        @yield('content')
      
      <!-- Aqui se consentra el contenido recibido por controlador -->
    
      
      </div>
<!-- Aqui se consentra el contenido recibido por controlador -->
    </div>
      

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">

            <span>Desarrollado por Telectronic &copy; <?php echo date("Y");?></span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->
 
    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">¿Confirma?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Esta seguro de "Cerrar sesión" </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <form action="{{route('login.destroy', '1')}}" method="POST">
      @csrf
      @method('DELETE')
      <button class="btn btn-primary">Salir</button>
          {{-- <a  href="/">Salir</a> --}}
        </form>
        </div>
      </div>
    </div>
  </div>
 
  <!-- Bootstrap core JavaScript-->
  <script src="{{asset('js/jquery.min.js')}}"></script>
  <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{asset('js/jquery.easing.min.js')}}"></script>

  <!-- Custom scripts for all pages-->

  <script src="{{asset('js/sb-admin-2.min.js')}}"></script>

  <!-- Page level plugins -->

  {{-- <script src="{{asset('js/Chart.min.js')}}"></script> --}}

  <!-- Page level custom scripts -->
  
  {{-- <script src="{{asset('js/chart-area-demo.js')}}"></script>
  <script src="{{asset('js/chart-pie-demo.js')}}"></script> --}}
<script type='text/javascript' src="{{asset('js/googlejquery.min.js')}}"></script>
<!-- Page level plugins -->
  <script src="{{asset('css/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('css/datatables/dataTables.bootstrap4.min.js')}}"></script>

	<script src="{{asset('js/jquery.mask.min.js')}}"></script>
	<script type='text/javascript' src="{{ asset('jQWidgets/jqxcore.js') }}"></script>
	<script type='text/javascript' src="{{ asset('jQWidgets/jqxchart.core.js') }}"></script>
	<script type='text/javascript' src="{{ asset('jQWidgets/jqxdraw.js') }}"></script>
	<script type='text/javascript' src="{{ asset('jQWidgets/jqxdata.js') }}"></script>




	
	<script type='text/javascript' src="{{ asset('jQWidgets/jqxdatetimeinput.js') }}"></script>
	<script type='text/javascript' src="{{ asset('jQWidgets/jqxcalendar.js') }}"></script>
	<script type='text/javascript' src="{{ asset('jQWidgets/jqxtooltip.js') }}"></script>
	<script type='text/javascript' src="{{ asset('jQWidgets/globalization/globalize.js') }}"></script>
	<script type='text/javascript' src="{{ asset('jQWidgets/globalization/globalize.culture.es.js') }}"></script>

{{-- <script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();   
});

$('#Configuraciones li a').on('click', function(){
    $('li a.activo').removeClass('activo');
    $(this).addClass('activo');
});

</script> --}}
<script>
   
//    $('li a').click(function(e) {
//   e.preventDefault();
   
//   $(this).addClass('a active');
//});

$(document).ready(function () { 
  var links = $('li a');
  $.each(links, function (key, va) { 
  if (va.href == document.URL) { 

    $(this).addClass('active collapse');
    e.preventDefault();
     } 
  }); 
});
    // accordionSidebar

    // nav nav-pills nav-stacked
  
  
</script>

</body>

</html>
