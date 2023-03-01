<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interseccion;
use App\LocalizacionDisplay;
use App\Mensaje;
use App\MensajeDisplay;
use Illuminate\Support\Facades\DB;
use App\PatronSemaforo;


class CentroMandoController extends Controller
{
    public function index()
    {
//        dd('llegue bro');
        $datos = LocalizacionDisplay::has('mensajeDisplay')->with('mensajeDisplay')->get();
       return $datos;
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
            return ['exito' => 200, 'id' => $interseccion->id,'msg' => 'Se ha registrado con exito'];

        } catch (\Exception $e) {

            DB::rollback();

            return ['exito' => 500,'msg' => 'Ha ocurrido un error: '.$e->getMessage()];

            dd($e->getMessage());
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

    public function selectmensajes(){
 
        $datos = Mensaje::get();
//dd('llegue bro', $datos);
       return $datos;
    }

     public function LocationDisplay(Request $request){
 //dd('hey bro this work', $request);

        //dd('llego aqui', $request);


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

        return $localizacion;
    

    }

     public function saveMassageDisplay(Request $request){
//dd('hey bro is working', $request->mensaje['id']);
        //dd($request->idDisplay);
        $mensajedisplay = new MensajeDisplay();
        $mensajedisplay->id_crear_mensaje = $request->mensaje['id'];
        $mensajedisplay->id_localizacion_display = $request->idDisplay;
        $mensajedisplay->tiempo = $request->tiempo;
        
   //     dd($localizacion);
        $mensajedisplay->save();

        return $mensajedisplay;
    

        

     }

     public function loadtabla(Request $request){
        //dd('chegue', $request);
//dd('i m sure than you ARE THE  throble:',$request);

          $datos = Mensajedisplay::with('Mensaje')->where('id_localizacion_display','=',$request['id'])->orderBy('id','desc')->paginate();


        // $datos = Mensajedisplay::with(['Mensaje:mensaje,tipo_mensaje'])->where('id_localizacion_display','=',$request['id'])->orderBy('id','desc')->paginate();
       
     //   dd('chegue', $datos);

        //$send= $datos[0]->Mensaje[0];
        return $datos;

        
     }

      public function deleteDisplayMensaje(Request $request){

        $Datos = Mensajedisplay::find($request->id)->delete();

                 return ['exito' => 200,'msg' => 'Se ha eliminado con exito'];
    //dd('informacion llego', $request);

      }









//return Interseccion::with('patrones')->orderBy('id','desc')->paginate();
    //

      // $intersecciones = Interseccion::where('interseccion','ilike','%'.$search.'%')->has('patrones')->with('patrones')->orderBy('id','desc')->paginate();where('id_localizacion_display','=', $request['id'])
      //$datos = Mensajedisplay::has('Mensaje')->with('Mensaje')->get();
        // $datos = LocalizacionDisplay::with('mensajeDisplay')->orderBy('id','desc')->paginate();
       


}
