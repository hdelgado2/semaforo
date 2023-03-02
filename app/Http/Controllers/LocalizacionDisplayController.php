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
        $localizacion->nombre_display = $request->nombre_display;
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

    public function botoneditardisplay(Request $request){
        //dd('llego', $request);

           LocalizacionDisplay::find($request->id)->update([
                'nombre_display' => $request->nombre_display,
            'ip_equipo'  => $request->ip_equipo,
            'mac_equipo' => $request->mac_equipo,
            'latitud' => $request->latitud,
            'longitud' => $request->longitud,
            'zoom' => $request->zoom,
            'observacion' => $request->observacion,
            ]);

return ['exito' => 200,'msg' => 'Se ha Registrado con exito'];

    }
    public function deletedisplay(Request $request){


 $display = LocalizacionDisplay::find($request->id)->delete();

         return ['exito' => 200,'msg' => 'Se ha eliminado con exito'];
    }

    public function search(){
       //  dd('lol prrbando');


//
         if ($search = \Request::get('q')) {
       $displaySearch = LocalizacionDisplay::where(function($query) use ($search){
        $query->where('nombre_display', 'ilike', "%$search%");
            // ->orWhere('pfd_presupuesto', 'ilike', "%$search%")
            // ->orWhere('tipo_mensaje', 'ilike', "%$search%")
            // ->orWhere('motivo_mensaje', 'ilike', "%$search%");
            
       })->paginate(10);
       
   }else{
        $displaySearch = LocalizacionDisplay::latest()->paginate(10);
        
   }
   return $displaySearch;
        
    }


}
