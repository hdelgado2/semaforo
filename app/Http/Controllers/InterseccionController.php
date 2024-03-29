<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interseccion;
use Illuminate\Support\Facades\DB;
use App\PatronSemaforo;

class InterseccionController extends Controller
{
    public function index()
    {
        return Interseccion::has('patrones')->with('patrones')->get();
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

            if(!$request->id){

                $interseccion = Interseccion::create([
                    'interseccion' => $request->interseccion, 
                    'latitud' => $latitud,
                    'longitud'   => $longitud,
                    'ip_equipo' => $request->ip_equipo,
                    'mac_equipo' => $request->mac_equipo,
                    'zoom'   => $request->zoom,
                    'observacion' => $request->observacion
                ]);
            }
            else{
            
                $interseccion = Interseccion::find($request->id);
                $interseccion->interseccion = $request->interseccion;
                $interseccion->latitud = $latitud;
                $interseccion->longitud   = $longitud;
                $interseccion->ip_equipo = $request->ip_equipo;
                $interseccion->mac_equipo = $request->mac_equipo;
                $interseccion->zoom   = $request->zoom;
                $interseccion->observacion = $request->observacion;
                $interseccion->save();

            }

            
            DB::commit();

            \Log::info('Se ha creado nueva interseccion '.$interseccion->interseccion);
            return ['exito' => true, 'code' => 200, 'id' => $interseccion->id,'msg' => 'Se ha registrado con exito'];

        } catch (\Exception $e) {
            DB::rollback();
            return ['exito' => false, 'code' => 500, 'msg' => 'Ha ocurrido un error: '.$e->getMessage()];
        }

    }

    public function update(Request $request){

    }

    public function setPatrones(Request $request){

        $this->validate($request, [
            'intersecciones' => 'required',
            'intersecciones_id' => 'required'
        ]);

        try {

            DB::beginTransaction();

            $intersecciones = PatronSemaforo::where('intersecciones_id',$request->intersecciones_id)->get();

            $intersecciones->each->delete();

            foreach( $request->intersecciones as  $patron ){
                
                $interseccion = PatronSemaforo::create([
                    'intersecciones_id'    => $request->intersecciones_id, 
                    'direccion' => $patron['direccion'],
                    'rojo'   => $patron['rojo'] ?? 0,
                    'rojo_cruce_izq' => $patron['rojo_cruce_izq'] ?? 0,
                    'roles_rojo_cruce_derid' => $patron['rojo_cruce_izq'] ?? 0,
                    'amarillo'   => $patron['amarillo'] ?? 0,
                    'amarillo_cruce_izq' => $patron['amarillo_cruce_izq'] ?? 0,
                    'amarillo_cruce_der' => $patron['amarillo_cruce_der'] ?? 0,
                    'verde' => $patron['verde'] ?? 0,
                    'verde_cruce_izq' => $patron['verde_cruce_izq'] ?? 0,
                    'verde_cruce_der' => $patron['verde_cruce_der'] ?? 0,
                    'sentido' => $patron['sentido']
                ]);
                
            }

            
            DB::commit();

            \Log::info('Se han guardado los patrones nuevos ');
            return ['exito' => 200,'msg' => 'Se ha registrado con exito'];

        } catch (\Exception $e) {

            DB::rollback();
            \Log::info('Error al guardar patron: '.$e->getMessage());
            return ['exito' => 500,'msg' => 'Ha ocurrido un error: '.$e->getMessage()];

            dd($e->getMessage());
        }

    }

    public function show(){

        return Interseccion::with('patrones')->orderBy('id','desc')->paginate();

    }

    public function searchInterseccion($search = ''){

        $intersecciones = null;

        if($search != ''){
             $intersecciones = Interseccion::where('interseccion','ilike','%'.$search.'%')->has('patrones')->with('patrones')->orderBy('id','desc')->paginate();

            if( !$intersecciones->isEmpty() ){
                return $intersecciones;
            }else{
                return $this->show();
            }
        }

        if($intersecciones == null)
            return $this->show();
        
    }
}
