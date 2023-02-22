<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MensajeDisplay extends Model
{
    use HasFactory;
    protected $table = 'mensajes_display';
    protected $fillable = ['id_crear_mensaje','id_localizacion_display','localizacion_display','tipo_programacion','etiqueta_proceso','tiempo'];


    // public function Mensaje(){
    //    return $this->hasMany('App\Mensaje','id_crear_mensaje','id');
    // }
    // public function LocationDisplay(){
    //    return $this->hasMany('App\LocalizacionDisplay','id_localizacion_display','id');
    // }


    
    public function Mensaje(){
       return $this->hasMany('App\Mensaje','id','id_crear_mensaje');
    }
    public function LocationDisplay(){
       return $this->hasMany('App\LocalizacionDisplay','id','id_localizacion_display');
    }
}
