<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interseccion;

class InterseccionController extends Controller
{
     public function index()
    {
        return Interseccion::has('patrones')->with('patrones')->get();
    }
}
