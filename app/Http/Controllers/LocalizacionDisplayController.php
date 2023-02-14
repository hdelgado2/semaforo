<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\LocalizacionDisplay;

class LocalizacionDisplayController extends Controller
{
    public function index()
    {
        return LocalizacionDisplay::get();
    }
}
