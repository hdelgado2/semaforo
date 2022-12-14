<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Menu;
use App\User;
use App\roles;

class UsuarioController extends Controller

{
    public function index()
    {
        
        $user = User::select('id','login','nombre','apellido','baneado')->paginate();
        return $user;
    }

    public function searchUser($searchUser)
    {
        
        $user = User::select('id','login','nombre','apellido','baneado')
               ->where('login','ILIKE','%'.explode('=',$searchUser)[1].'%')->paginate(10);
        return $user;
    }

    public function createUser(Request $request)
    {
       # dd($request->all());
        $this->validate($request, [
            'login' => 'required',
            'password' => 'required',
            'nombre' => 'required',
            'apellido' => 'required',
            'roles' => 'required',
            'cedula' => 'required'
        ]);

        try {
            \DB::beginTransaction();

            User::create([
                'login'    => $request->login, 
                'password' => md5($request->password),
                'nombre'   => $request->nombre,
                'apellido' => $request->apellido,
                'roles_id' => $request->roles,
                'cedula'   => $request->cedula
            ]);

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            dd($e->getMessage());
        }

        return ['exito' => 200,'msg' => 'Se ha Registrado con exito'];
    }
    public function getRoles()
    {
        
        return roles::select('nombre_rol','id')->where('activo',true)->get();
    }

    public function getRolesEditar($id)
    {
        return roles::select('nombre_rol','id')->where('id',$id)->where('activo',true)->get();
    }

    public function deleteUser($id)
    {
            $user = User::find($id)->delete();
            $user1 = User::select('id','login','nombre','apellido','baneado')->paginate(10);
            return $user1;
    }

    public function editUser($id)
    {
        $user = User::find($id);
        
        return [
            'cedula' => $user->cedula,
            'login'  => $user->login,
            'password' => $user->password,
            'nombre' => $user->nombre,
            'roles' => $this->getRolesEditar($user->roles_id),
            'apellido' => $user->apellido,
            'roless' => $this->getRoles()
        ];
    }

    public function editUserRegistro(Request $request)
    {
        
        $this->validate($request, [
            'login' => 'required',
            'password' => 'required',
            'nombre' => 'required',
            'apellido' => 'required',
            'roles' => 'required',
            'cedula' => 'required'
        ]);

        try {
            \DB::beginTransaction();

            User::find($request->idUserEdit)->update([
                'login'    => $request->login, 
                'password' => md5($request->password),
                'nombre'   => $request->nombre,
                'apellido' => $request->apellido,
                'roles_id' => $request->roles,
                'cedula'   => $request->cedula
            ]);

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            dd($e->getMessage());
        }

        return ['exito' => 200,'msg' => 'Se ha Registrado con exito'];
    }
}
