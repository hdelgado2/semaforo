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

    <!-- Fonts -->
    <link rel="stylesheet" href="{{asset('/css/font-awesome/all.min.css')}}">
     <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('/css/adminlte/adminlte.min.css')}}">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css"
            integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14="
            crossorigin=""/>


    <style>
          #map { 
              height: 180px;
          }
          .login-card {
              background: rgba(255, 255, 255, 0.1);
              border-radius: 16px;  
              box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
              backdrop-filter: blur(5px);
              -webkit-backdrop-filter: blur(5px);
              border: 1px solid rgba(255, 255, 255, 0.3);
              /* From https://css.glass */
              background: rgba(255, 255, 255, 0.1);
              border-radius: 16px;
              box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
              backdrop-filter: blur(5px);
              -webkit-backdrop-filter: blur(5px);
              border: 1px solid rgba(255, 255, 255, 0.3);
          }
    </style>
</head>
<body style="background-image: url('images/wallpapers/semaforo1.jpg');">
  <div id="app">
    <main class="py-5">
     @yield('content')
    </main>

    <script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js"
            integrity="sha256-o9N1jGDZrf5tS+Ft4gbIK7mYMipq9lqpVJ91xHSyKhg="
            crossorigin=""></script>
            
    <script src="{{asset('js/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap -->
    <script src="{{asset('js/bootstrap/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE -->
    <script src="{{asset('js/adminlte/adminlte.js')}}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{asset('js/adminlte/pages/dashboard3.js')}}"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.1/chart.min.js" integrity="sha512-2uu1jrAmW1A+SMwih5DAPqzFS2PI+OPw79OVLS4NJ6jGHQ/GmIVDDlWwz4KLO8DnoUmYdU8hTtFcp8je6zxbCg==" type="module" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.0.1/chart.min.js" integrity="sha512-tQYZBKe34uzoeOjY9jr3MX7R/mo7n25vnqbnrkskGr4D6YOoPYSpyafUAzQVjV6xAozAqUFIEFsCO4z8mnVBXA==" type="module" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
  </div>
</body>
</html>
