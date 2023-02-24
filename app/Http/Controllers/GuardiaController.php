<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Guardia;

class GuardiaController extends Controller
{
    public function index()
    {
        return Guardia::paginate();
    }

    public function getGuardias()
    {
        return Guardia::get(); 
    }
}
