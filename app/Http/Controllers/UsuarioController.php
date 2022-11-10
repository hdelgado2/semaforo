<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Menu;
use App\User;
class UsuarioController extends Controller
{
    public function index()
    {
        
        $user = User::select('id','login','nombre','apellido','baneado')->paginate(10);
        return $user;
    }

    public function searchUser($searchUser)
    {
        
        $user = User::select('id','login','nombre','apellido','baneado')
               ->where('login','ILIKE','%'.explode('=',$searchUser)[1].'%')->paginate(10);
        return $user;
    }
}
