<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\roles;
class RolesController extends Controller
{
    public function index()
    {
        
        return roles::where('activo',true)->paginate(10);
    }

    public function createRoles(Request $request)
    {
        $this->validate($request, [
            'role' => 'required',
            'desc' => 'required',
            'activo' => 'required',
           
        ]);

        try {
             \DB::beginTransaction();

              roles::create([
                'nombre_rol' => $request->role,
                'descripcion' => $request->desc,
                'activo' => $request->activo
              ]);
             \DB::commit();
        } catch (\Exception $th) {
            \DB::rollback();
            dd($th->getMessage());
        }
        return ['exito' => 200,'msg' => 'Se ha Registrado con exito'];

    }

    public function search($role)
    {
        return roles::where('nombre_rol','ilike','%'.$role.'%')->where('activo',true)->paginate(10);
    }
}
