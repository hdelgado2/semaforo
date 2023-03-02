<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use PhpMqtt\Client\Facades\MQTT;

class mqttMensajeController extends Controller
{
       public function publish(Request $request){
        dd('wassap bro'):
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
                $instruccion = $this->makeInstruction($objeto['sentido'], $objeto['color'], $objeto['tiempo']);
                $topico = 'vit/topic/prueba/'.$objeto['ip_equipo'];
                \Log::warning($topico);
                MQTT::publish( $topico, $instruccion);
            }

            else if ( $objeto['sentido'] != '' && $objeto['color'] == '' && $objeto['tiempo'] < 1){
                $instruccion = $this->makeInstruction($objeto['sentido'], $objeto['color'], $objeto['tiempo']);
                $topico = 'vit/topic/prueba/'.$objeto['ip_equipo'];
                \Log::warning($topico);
                MQTT::publish($topico, $instruccion);
            }

            else if ( $objeto['sentido'] == '' && $objeto['color'] != '' ){
                $instruccion = $this->makeInstruction($objeto['sentido'], $objeto['color'], $objeto['tiempo']);
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

    public function makeInstruction( $inst = null, $color = null, $tiempo = 0)
    {
        $instruccion = '';

        if( $inst != '' && $inst != null ) $instruccion = $inst;
        else if ($color != '' && $color != null ) $instruccion = $color.':';
        
        if( $tiempo > 0 && $tiempo != null ) $instruccion.':'.$tiempo.null;

        return trim($instruccion);
    }
}
