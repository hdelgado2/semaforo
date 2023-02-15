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

        // $this->validate($request, [
        //     'login' => 'required',
        //     'password' => 'required',
        //     'nombre' => 'required',
        //     'apellido' => 'required',
        //     'roles' => 'required',
        //     'cedula' => 'required'
        // ]);

        // try {
        //     \DB::beginTransaction();

        //     User::find($request->idUserEdit)->update([
        //         'login'    => $request->login, 
        //         'password' => md5($request->password),
        //         'nombre'   => $request->nombre,
        //         'apellido' => $request->apellido,
        //         'roles_id' => $request->roles,
        //         'cedula'   => $request->cedula
        //     ]);

        //     \DB::commit();
        // } catch (\Exception $e) {
        //     \DB::rollback();
        //     dd($e->getMessage());
        // }

        // return ['exito' => 200,'msg' => 'Se ha Registrado con exito'];
    }


    public function deletemensaje(Request $request)
    {
      //  dd('llego', $request->id['id']);

         $mensaje = Mensaje::find($request->id['id'])->delete();

         return ['exito' => 200,'msg' => 'Se ha eliminado con exito'];
            // $user1 = User::select('id','login','nombre','apellido','baneado')->paginate(10);
            // return $user1;

    }


    
}
