@extends('layouts.app')

@section('menu')
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
@endforeach
@endsection