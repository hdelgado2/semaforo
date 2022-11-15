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
    </style>
</head>
<body class="hold-transition sidebar-mini">
  <div class="content-wrapper">
    <main class="py-4">
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

</body>
</body>
</html>
