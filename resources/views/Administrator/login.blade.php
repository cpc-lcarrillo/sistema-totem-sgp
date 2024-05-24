<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
 <link rel="shortcut icon" href="{{asset('/img/fondos/favicon.ico')}}">
  <title>SGT | Login</title>

  <!-- Custom fonts for this template-->
  <link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
  <link href="{{asset('https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i')}}" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="{{asset('/css/sb-admin-2.min.css')}}" rel="stylesheet">
<style>
.centrar{  
  padding-top: 11%;  
}

.body{  
  background: url("{{asset('img/fondos/fondocpc.jpg')}}");
   /* Center the image */
  background-repeat: no-repeat;
  height: 100%;
  width: 100%;
}
</style>
</head>

<body class=" mx-auto body" >
<div class="d-none d-lg-block bg-primary" style="position:absolute; top:0%;  left:50%; height:100%;">      
<img src="{{asset('img/fondos/fondocpc2.jpg')}}" width="100%" height="100%">
</div>
  <div class="container">

    <!-- Outer Row -->
    

    <div class="row justify-content-end">
     
      <div class="col-xl-5 col-lg-6 col-md-10 centrar" style="left: 3%; padding-top: 7%; right:3%;  " >

        <div class="card o-hidden border-10 shadow-lg my-0 ">
          <div class="card-body p-0" >
            <!-- Nested Row within Card Body -->
            
            <div class="row" >
              <div class="col-lg-11">
              
                <div class="p-5" >
                  <div class="text-center my-4">
                    
                    <img src="{{asset('img/logo.png')}}" class="img-fluid">
                  </div>
                  
                <form action="{{ route('login.store') }}" method="post">
                   @csrf
                    <div class="form-group">
                      <input type="text" name="Usuario" class="form-control form-control-user" aria-describedby="emailHelp" placeholder="Usuario">
                      <span class="text-danger">{{$errors->first('Usuario')}}</span>
                    </div>
                    <div class="form-group">
                      <input type="password" name="Clave" class="form-control form-control-user"  placeholder="Clave">
                      <span class="text-danger">{{$errors->first('Clave')}}</span>
                    </div>

                    
                    
                    <div class="form-group">
                     
                    </div>
                    <input type="submit" class="btn text-white  btn-user btn-block" style="background-color: #E27923;"  >
                    
                  @if (Session::has('message'))
                  <BR>
                  <div class="alert alert-danger">{{ Session::get('message') }}</div>
                  @endif
                    
                    
                  </form>

                  <hr>

                  <div class="text-center">
                    
                  </div>
                </div>
              
              </div>
            </div>
          </div>
         
        </div>
     </div>

      </div>

    </div>

</div>
  </div>


<div class="d-none d-lg-block" style="position:absolute; top:55%; left:8%;">
      <BR>
      <h2 style="color:#e27923;font-weight: 900;text-shadow: -2px 4px 0 #044d6d;"><b>PUERTO CORONEL</b>, <br> MÁS CERCANO, <br> EFICIENTE Y TECNOLÓGICO</h2>


</div> 

  <!-- Bootstrap core JavaScript-->
  <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.jss')}}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{asset('js/sb-admin-2.min.js')}}"></script>

</body>

</html>
