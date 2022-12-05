<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpMqtt\Client\Facades\MQTT;

class MqttController extends Controller
{
    public function publish(Request $request){

        try{

            if( $request->sentido != '' && $request->color == '' && $request->tiempo > 0){

                $instruccion = $request->sentido.':'.$request->tiempo;

                MQTT::publish('vit/topic/prueba', $instruccion);
            }

            else if ( $request->sentido == '' && $request->color != '' ){

                $instruccion = $request->color.':'.$request->tiempo;

                MQTT::publish('vit/topic/prueba', $instruccion);
            }
        
            MQTT::disconnect();

            \Log::info('Instruccion enviada: '.$instruccion);
            return ['code'=>200, 'exito' => true,'msg' => 'Instruccion enviada'];

        }catch( \Exception $e ){

            \Log::info('Error al enviar instrucción: '.$e->getMessage());
            return ['code' => 500, 'exito' => false, 'msg' => 'Ha ocurrido un error: '];
        }

        //$topic; 
        //$host;
      //  dd($request->color);
        

    }
}
