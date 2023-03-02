<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Mensaje;

class MensajesController extends Controller
{
    public function index(){
        return Mensaje::paginate();
    }

    public function store(Request $request){
 //dd($request);

        $mensaje = new Mensaje();
        $mensaje->tipo_mensaje = $request->tipo_mensaje;
        $mensaje->mensaje = $request->mensaje;
        $mensaje->motivo_mensaje = $request->motivo_mensaje;
        $mensaje->save();

        return ['exito' => 200, 'id' => $mensaje->id,'msg' => 'Se ha registrado con exito'];
    }


    //cargar datos
public function cargarmensajeedit(Request $request)
    {

        //  dd('llego', $request->id['id']);
        $mensajeedit = Mensaje::find($request->id['id']);
      
        return [
            'mensaje' => $mensajeedit->mensaje,
            'motivo_mensaje'  => $mensajeedit->motivo_mensaje,
            'tipo_mensaje' => $mensajeedit->tipo_mensaje,
            
            
        ];

    }

    //funcion para editar mensajes

    public function botoneditar(Request $request)
    {
      // dd('llego', $request->mensaje);

     Mensaje::find($request->id['id'])->update([
                'mensaje' => $request->mensaje,
            'motivo_mensaje'  => $request->motivo_mensaje,
            'tipo_mensaje' => $request->tipo_mensaje,
            ]);

return ['exito' => 200,'msg' => 'Se ha Registrado con exito'];

      
    }


    public function deletemensaje(Request $request)
    {
      //  dd('llego', $request->id['id']);

         $mensaje = Mensaje::find($request->id['id'])->delete();

         return ['exito' => 200,'msg' => 'Se ha eliminado con exito'];
            // $user1 = User::select('id','login','nombre','apellido','baneado')->paginate(10);
            // return $user1;

    }



    public function search(){
        
         if ($search = \Request::get('q')) {
       $mensajesSearch = Mensaje::where(function($query) use ($search){
        $query->where('mensaje', 'ilike', "%$search%")
            // ->orWhere('pfd_presupuesto', 'ilike', "%$search%")
            ->orWhere('tipo_mensaje', 'ilike', "%$search%")
            ->orWhere('motivo_mensaje', 'ilike', "%$search%");
            
       })->paginate(10);
       
   }else{
        $mensajesSearch = Mensaje::latest()->paginate(10);
        
   }
   return $mensajesSearch;
        
    }
    


    
}
