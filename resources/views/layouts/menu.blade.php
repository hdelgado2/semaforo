@extends('layouts.app')
@if( Auth::user() )
@section('menu')
<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
   
   
@foreach ($menu as $item)
<li class="nav-item">
  <a href="#" class="nav-link">
    <i class="nav-icon fas fa-copy"></i>
    <p style="font-size: 10px; color:aliceblue">
     {{$item->nombre_menu}}
     <i class="fas fa-angle-left right"></i>
    </p>
  </a>
  
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


@endsection
@endif