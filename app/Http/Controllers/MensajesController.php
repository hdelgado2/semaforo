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

        $mensaje = new Mensaje();
        $mensaje->tipo_mensaje = $request->tipo_mensaje;
        $mensaje->mensaje = $request->mensaje;
        $mensaje->motivo_mensaje = $request->motivo_mensaje;
        $mensaje->save();

        return ['exito' => 200, 'id' => $mensaje->id,'msg' => 'Se ha registrado con exito'];
    }
}
