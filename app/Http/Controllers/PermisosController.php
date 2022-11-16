<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Menu;
class PermisosController extends Controller
{
    public function index()
    {
        return User::paginate(10);
    }

    public function menu()
    {
        return Menu::all();
    }
}
