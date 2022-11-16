<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class PermisosController extends Controller
{
    public function index()
    {
        return User::paginate(10);
    }
}
