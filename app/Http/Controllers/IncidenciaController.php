<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Incidencia;

class IncidenciaController extends Controller
{
    public function index()
    {
        return Incidencia::with('guardia.usuario','interseccion','tipo')->paginate();
    }
}
