<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpMqtt\Client\Facades\MQTT;

class MqttController extends Controller
{

    public function publish(Request $request){
        try{
            $time = $request->intervalo_entre_interseccion > 0 ? $request->intervalo_entre_interseccion : 2;
            if( count($request->rutas['semaforos']) ){
                foreach($request->rutas['semaforos'] as $semaforo){
                    $this->handlePublish($semaforo);
                    sleep($time);
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

    public function handlePublish($objeto){

        try{

            $instruccion = '';
            $topico = '';

            if( $objeto['sentido'] != '' && $objeto['color'] == '' && $objeto['tiempo'] > 0){
                $instruccion = $objeto['sentido'].':'.$objeto['tiempo'].null;
                $instruccion = trim($instruccion);
                $topico = 'vit/topic/prueba/'.$objeto['ip_equipo'];
                \Log::warning($topico);
                MQTT::publish( $topico, $instruccion);
            }

            else if ( $objeto['sentido'] != '' && $objeto['color'] == '' && $objeto['tiempo'] < 1){
                $instruccion = $objeto['sentido'].'';
                $topico = 'vit/topic/prueba/'.$objeto['ip_equipo'];
                \Log::warning($topico);
                MQTT::publish($topico, $instruccion);
            }

            else if ( $objeto['sentido'] == '' && $objeto['color'] != '' ){
                $instruccion = $objeto['color'].':'.$objeto['tiempo'].null;
                $instruccion = trim($instruccion);
                $topico = 'vit/topic/prueba/'.$objeto['ip_equipo'];
                \Log::warning($topico);
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
