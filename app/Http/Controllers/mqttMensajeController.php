<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use PhpMqtt\Client\Facades\MQTT;

class mqttMensajeController extends Controller
{
      public function index()
    {
        return User::paginate(10);
    }

    public function menu()
    {
        return Menu::all();
    }

    public function addpermisos(Request $request)
    {
        
        
        $this->validate($request, [
            'permisos' => 'required',
        ]);

        try{
            \DB::beginTransaction();

            collect($request->permisos)->map(function($value) use ($request){
                
                collect($value['niveles'])->map(function ($value2,$index) use ($value,$request)
                {
                    if($value2 === true){
                        Permisos::updateOrCreate([
                            'usuario' => $request->login,
                            'ruta' =>  Menu::where('nombre_menu',$value['modulo'])->first()->ruta_archivo,
                            'nivel' => $request->niveles2[$index]
                        ],[
                            'nivel' => $request->niveles2[$index]
                        ]);
                    }
                    
                });
            });

            \DB::commit();
        }catch(\Exception $e){  
            \DB::commit();
            return ['exito' => 500,'msg' => 'Error de permisos'];
        }

        return ['exito' => 200,'msg' => 'Se ha Registrado con exito'];

    }
}
