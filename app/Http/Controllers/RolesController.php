<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\roles;
class RolesController extends Controller
{
    public function index()
    {
        
        return roles::paginate(10);
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

    public function searchRoles($role)
    {
        return roles::where('nombre_rol','ilike','%'.explode('=',$role)[1].'%')->paginate(10);
    }

    public function deleteroles($role)
    {
            $deleteRole = roles::find($role)->delete();
            return roles::paginate(10);
    }
}
