<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Fonts -->
    <link rel="stylesheet" href="{{asset('/css/font-awesome/all.min.css')}}">
     <!-- Theme style -->
     <link rel="stylesheet" href="{{asset('/css/adminlte/adminlte.min.css')}}">
     <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">
     <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

</head>
<body class="hold-transition sidebar-mini">
    <div id="app">
        <div class="wrapper">
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
              <!-- Left navbar links -->
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                  <a href="#" class="nav-link">Home</a>
                </li>
              </ul>
          
              <!-- Right navbar links -->
              
            </nav>
            <!-- /.navbar -->
          
            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
              <!-- Brand Logo -->
              <a href="#" class="brand-link">
                
                <span class="brand-text font-weight-light">AdminLTE 3</span>
              </a>
              
              <!-- Sidebar -->
              <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                  <div class="image">
                    <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                  </div>
                  @guest
                  <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                  </li>
                  @if (Route::has('register'))
                  <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                  </li>     
                  @endif       
                  @else
                  <div class="info">
                    <a href="#" class="d-block">{{Auth::user()->nombre}}</a>
                  </div>
                  @endif    
                </div>
                <main class="py-4">
                  <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                     
                     
                  @foreach ($menu as $item)
                     
                  <li class="nav-item">
                    <router-link to="{{'/'.$item->ruta_archivo}}" class="nav-link">
                      <i class="nav-icon fas fa-copy"></i>
                      <p style="font-size: 10px; color:aliceblue">
                       {{$item->nombre_menu}}
                       <i class="fas fa-angle-left right"></i>
                      </p>
                    </router-link>
                    
                  </li>
                  
                  @endforeach
                  <li style="font-size: 10px;color:aliceblue">
                                            
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                                     <i class="nav-icon fas fa-copy"></i>
                        {{ __('Logout') }}
                    </a>
                  
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                  
                  </li>    
                      
                    </ul>
                    
                  </nav>
                </main> 
                
                <!-- /.sidebar-menu -->
              </div>
              <!-- /.sidebar -->
            </aside>
          
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
              <main class="py-4">
                <router-view></router-view>
              </main>
              <!-- Content Header (Page header) -->
              {{-- <div class="content-header">
                <div class="container-fluid">
                  <div class="row mb-2">
                    <div class="col-sm-6">
                      <h1 class="m-0">Dashboard v3</h1>
                    </div><!-- /.col -->
                  </div><!-- /.row -->
                </div><!-- /.container-fluid -->
              </div> --}}
              <!-- /.content-header -->
            </div>
            <!-- /.content-wrapper -->
          
            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
              <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
          
            <!-- Main Footer -->
            <footer class="main-footer">
              <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
              All rights reserved.
              <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.2.0
              </div>
            </footer>
          </div>

       
    </div>
<script src="{{asset('js/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('js/bootstrap/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE -->
<script src="{{asset('js/adminlte/adminlte.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('js/adminlte/pages/dashboard3.js')}}"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.1/chart.min.js" integrity="sha512-2uu1jrAmW1A+SMwih5DAPqzFS2PI+OPw79OVLS4NJ6jGHQ/GmIVDDlWwz4KLO8DnoUmYdU8hTtFcp8je6zxbCg==" type="module" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.0.1/chart.min.js" integrity="sha512-tQYZBKe34uzoeOjY9jr3MX7R/mo7n25vnqbnrkskGr4D6YOoPYSpyafUAzQVjV6xAozAqUFIEFsCO4z8mnVBXA==" type="module" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
 -->
</script>


</body>
</html>
<!--<ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href="pages/layout/top-nav.html" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Top Navigation</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="pages/layout/top-nav-sidebar.html" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Top Navigation + Sidebar</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="pages/layout/boxed.html" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Boxed</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="pages/layout/fixed-sidebar.html" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Fixed Sidebar</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="pages/layout/fixed-sidebar-custom.html" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Fixed Sidebar <small>+ Custom Area</small></p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="pages/layout/fixed-topnav.html" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Fixed Navbar</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="pages/layout/fixed-footer.html" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Fixed Footer</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="pages/layout/collapsed-sidebar.html" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Collapsed Sidebar</p>
                          </a>
                        </li>
                        
                      </ul>-->
