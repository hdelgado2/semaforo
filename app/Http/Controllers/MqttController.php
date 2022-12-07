<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpMqtt\Client\Facades\MQTT;

class MqttController extends Controller
{
    public function publish(Request $request){

        try{

            $instruccion = '';
            $topico = '';

            if( $request->sentido != '' && $request->color == '' && $request->tiempo > 0){

                $instruccion = $request->sentido.':'.$request->tiempo.null;

                $topico = 'vit/topic/prueba/'.$request->ip_equipo;

                MQTT::publish( $topico, $instruccion.null);
            }

            else if ( $request->sentido != '' && $request->color == '' && $request->tiempo < 1){

                $instruccion = trim($request->sentido.null);

                $topico = 'vit/topic/prueba/'.$request->ip_equipo;

                MQTT::publish($topico, $instruccion);
            }

            else if ( $request->sentido == '' && $request->color != '' ){

                $instruccion = $request->color.':'.$request->tiempo.null;

                $topico = 'vit/topic/prueba/'.$request->ip_equipo;

                MQTT::publish($topico, $instruccion.null);
            }
        
            MQTT::disconnect();

            \Log::info('Instruccion enviada: '.$instruccion.' a topico: '.$topico);
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
