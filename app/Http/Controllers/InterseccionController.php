<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interseccion;
use Illuminate\Support\Facades\DB;

class InterseccionController extends Controller
{
    public function index()
    {
        return Interseccion::with('patrones')->get();
    }

    public function store(Request $request)
    {
        //dd($request);
        $this->validate($request, [
            'interseccion' => 'required',
            'latitud' => 'required',
            'longitud' => 'required',
            'ip_equipo' => 'sometimes',
            'mac_equipo' => 'sometimes',
            'zoom' => 'sometimes'
        ]);

        try {

            DB::beginTransaction();

            $latitud = substr($request->latitud, 0, 8);
            $longitud = substr($request->longitud, 0, 9);

            $interseccion = Interseccion::create([
                'interseccion' => $request->interseccion, 
                'latitud' => $latitud,
                'longitud'   => $longitud,
                'ip_equipo' => $request->ip_equipo,
                'mac_equipo' => $request->mac_equipo,
                'zoom'   => $request->zoom,
                'observacion' => $request->observacion
            ]);

            DB::commit();

            \Log::info('Se ha creado nueva interseccion '.$interseccion->interseccion);
            return ['exito' => 200,'msg' => 'Se ha registrado con exito'];

        } catch (\Exception $e) {

            DB::rollback();

            return ['exito' => 500,'msg' => 'Ha ocurrido un error: '.$e->getMessage()];

            dd($e->getMessage());
        }

    }

    public function update(Request $request){

    }

    public function setPatrones(Request $request){

        dd($request);
        // $this->validate($request, [
        //     'login' => 'required',
        //     'password' => 'required',
        //     'nombre' => 'required',
        //     'apellido' => 'required',
        //     'roles' => 'required',
        //     'cedula' => 'required'
        // ]);

        try {

            DB::beginTransaction();

            $interseccion = Interseccion::create([
                'login'    => $request->login, 
                'password' => md5($request->password),
                'nombre'   => $request->nombre,
                'apellido' => $request->apellido,
                'roles_id' => $request->roles,
                'cedula'   => $request->cedula
            ]);

            DB::commit();

            \Log::info('Se ha creado nueva interseccion '.$interseccion);
            return ['exito' => 200,'msg' => 'Se ha registrado con exito'];

        } catch (\Exception $e) {

            DB::rollback();

            return ['exito' => 500,'msg' => 'Ha ocurrido un error: '.$e->getMessage()];

            dd($e->getMessage());
        }

    }
}
