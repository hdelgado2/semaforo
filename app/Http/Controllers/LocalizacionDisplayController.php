<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\LocalizacionDisplay;

class LocalizacionDisplayController extends Controller
{
    public function index()
    {
         $displays=LocalizacionDisplay::get();

        //dd('llego', $displays);
        return $displays;
        //return LocalizacionDisplay::get();
    }
    public function guardarlacalizacionesdisplays(Request $request){


      //  dd('llego aqui', $request);


        $localizacion = new LocalizacionDisplay();
        $localizacion->nombre_display = $request->interseccion;
        $localizacion->ip_equipo = $request->ip_equipo;
        $localizacion->mac_equipo = $request->mac_equipo;
        $localizacion->latitud = $request->latitud;
        $localizacion->longitud = $request->longitud;
        $localizacion->zoom = $request->zoom;
        $localizacion->observacion = $request->observacion;
   //     dd($localizacion);
        $localizacion->save();

        return ['exito' => 200, 'Se ha registrado con exito'];
    }

    public function cargardisplayedit(Request $request){

       // dd('llegue bro', $request);

          //  dd('llego', $request->id['id']);
        $displayedit = LocalizacionDisplay::find($request->id['id']);
      
        return [

            'nombre_display' => $displayedit->nombre_display,
            'ip_equipo' => $displayedit->ip_equipo,
            'mac_equipo' => $displayedit->mac_equipo,
            'latitud' => $displayedit->latitud,
            'longitud' => $displayedit->longitud,
            'zoom' => $displayedit->zoom,
            'observacion' => $displayedit->observacion,
            

            // 'mensaje' => $mensajeedit->mensaje,
            // 'motivo_mensaje'  => $mensajeedit->motivo_mensaje,
            // 'tipo_mensaje' => $mensajeedit->tipo_mensaje,
            
            
        ];
    }



    // public function store(Request $request)
    // {
    //     //dd($request);
    //     $this->validate($request, [
    //         'interseccion' => 'required',
    //         'latitud' => 'required',
    //         'longitud' => 'required',
    //         'ip_equipo' => 'sometimes',
    //         'mac_equipo' => 'sometimes',
    //         'zoom' => 'sometimes'
    //     ]);

    //     try {

    //         DB::beginTransaction();

    //         $latitud = substr($request->latitud, 0, 8);
    //         $longitud = substr($request->longitud, 0, 9);

    //         if(!$request->id){

    //             $interseccion = Interseccion::create([
    //                 'interseccion' => $request->interseccion, 
    //                 'latitud' => $latitud,
    //                 'longitud'   => $longitud,
    //                 'ip_equipo' => $request->ip_equipo,
    //                 'mac_equipo' => $request->mac_equipo,
    //                 'zoom'   => $request->zoom,
    //                 'observacion' => $request->observacion
    //             ]);
    //         }
    //         else{
            
    //             $interseccion = Interseccion::find($request->id);
    //             $interseccion->interseccion = $request->interseccion;
    //             $interseccion->latitud = $latitud;
    //             $interseccion->longitud   = $longitud;
    //             $interseccion->ip_equipo = $request->ip_equipo;
    //             $interseccion->mac_equipo = $request->mac_equipo;
    //             $interseccion->zoom   = $request->zoom;
    //             $interseccion->observacion = $request->observacion;
    //             $interseccion->save();

    //         }

            
    //         DB::commit();

    //         \Log::info('Se ha creado nueva interseccion '.$interseccion->interseccion);
    //         return ['exito' => 200, 'id' => $interseccion->id,'msg' => 'Se ha registrado con exito'];

    //     } catch (\Exception $e) {

    //         DB::rollback();

    //         return ['exito' => 500,'msg' => 'Ha ocurrido un error: '.$e->getMessage()];

    //         dd($e->getMessage());
    //     }

    // }

    // public function update(Request $request){

    // }

    // public function setPatrones(Request $request){

    //     $this->validate($request, [
    //         'intersecciones' => 'required',
    //         'intersecciones_id' => 'required'
    //     ]);

    //     try {

    //         DB::beginTransaction();

    //         $intersecciones = PatronSemaforo::where('intersecciones_id',$request->intersecciones_id)->get();

    //         $intersecciones->each->delete();

    //         foreach( $request->intersecciones as  $patron ){
                
    //             $interseccion = PatronSemaforo::create([
    //                 'intersecciones_id'    => $request->intersecciones_id, 
    //                 'direccion' => $patron['direccion'],
    //                 'rojo'   => $patron['rojo'] ?? 0,
    //                 'rojo_cruce_izq' => $patron['rojo_cruce_izq'] ?? 0,
    //                 'roles_rojo_cruce_derid' => $patron['rojo_cruce_izq'] ?? 0,
    //                 'amarillo'   => $patron['amarillo'] ?? 0,
    //                 'amarillo_cruce_izq' => $patron['amarillo_cruce_izq'] ?? 0,
    //                 'amarillo_cruce_der' => $patron['amarillo_cruce_der'] ?? 0,
    //                 'verde' => $patron['verde'] ?? 0,
    //                 'verde_cruce_izq' => $patron['verde_cruce_izq'] ?? 0,
    //                 'verde_cruce_der' => $patron['verde_cruce_der'] ?? 0,
    //                 'sentido' => $patron['sentido']
    //             ]);
                
    //         }

            
    //         DB::commit();

    //         \Log::info('Se han guardado los patrones nuevos ');
    //         return ['exito' => 200,'msg' => 'Se ha registrado con exito'];

    //     } catch (\Exception $e) {

    //         DB::rollback();
    //         \Log::info('Error al guardar patron: '.$e->getMessage());
    //         return ['exito' => 500,'msg' => 'Ha ocurrido un error: '.$e->getMessage()];

    //         dd($e->getMessage());
    //     }

    // }

    // public function show(){

    //     return Interseccion::with('patrones')->orderBy('id','desc')->paginate();

    // }

    // public function searchInterseccion($search = ''){

    //     $intersecciones = null;

    //     if($search != ''){
    //          $intersecciones = Interseccion::where('interseccion','ilike','%'.$search.'%')->has('patrones')->with('patrones')->orderBy('id','desc')->paginate();

    //         if( !$intersecciones->isEmpty() ){
    //             return $intersecciones;
    //         }else{
    //             return $this->show();
    //         }
    //     }

    //     if($intersecciones == null)
    //         return $this->show();
        

        
    // }
}
