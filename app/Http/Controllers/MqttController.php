<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpMqtt\Client\Facades\MQTT;

class MqttController extends Controller
{
    public function publish(Request $request){

        //$topic; 
        //$host;

        MQTT::publish('some/topic', 'Hello World!');
        MQTT::disconnect();

    }
}
