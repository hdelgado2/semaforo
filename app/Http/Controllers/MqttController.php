<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpMqtt\Client\Facades\MQTT;

class MqttController extends Controller
{

    public function publish(Request $request){
        try{
            if( count($request->ips) ){
                foreach($request->ips as $ip){
                    $request->ip_equipo = $ip;
                    \Log::info($request->ip_equipo);
                    $this->handlePublish($request);
                }
            }else{
                $this->handlePublish($request);
            }
            return ['code'=>200, 'exito' => true,'msg' => 'Instruccion enviada'];
        }catch( \Exception $e ){
            \Log::info('Error al enviar instrucción: '.$e->getMessage());
            return ['code' => 500, 'exito' => false, 'msg' => 'Ha ocurrido un error: '];
        }
        
    }

    public function handlePublish(Request $request){

        try{

            $instruccion = '';
            $topico = '';

            if( $request->sentido != '' && $request->color == '' && $request->tiempo > 0){

                $instruccion = $request->sentido.':'.$request->tiempo.null;

                $instruccion = trim($instruccion);

                $topico = 'vit/topic/prueba/'.$request->ip_equipo;

                MQTT::publish( $topico, $instruccion);
            }

            else if ( $request->sentido != '' && $request->color == '' && $request->tiempo < 1){

                $instruccion = $request->sentido.'';

                $topico = 'vit/topic/prueba/'.$request->ip_equipo;

                MQTT::publish($topico, $instruccion);
            }

            else if ( $request->sentido == '' && $request->color != '' ){

                $instruccion = $request->color.':'.$request->tiempo.null;

                $instruccion = trim($instruccion);

                $topico = 'vit/topic/prueba/'.$request->ip_equipo;

                MQTT::publish($topico, $instruccion);
            }
        
            MQTT::disconnect();

            \Log::info('Instruccion enviada: '.$instruccion.' a topico: '.$topico);
            return ['code'=>200, 'exito' => true,'msg' => 'Instruccion enviada'];

        }catch( \Exception $e ){

            \Log::info('Error al enviar instrucción: '.$e->getMessage());
            return ['code' => 500, 'exito' => false, 'msg' => 'Ha ocurrido un error: '];
        }

    }
}
