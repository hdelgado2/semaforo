<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocalizacionDisplay extends Model
{
    use HasFactory;

    protected $table = 'localizacion_display';
    protected $fillable = [
        'nombre_display', 'ip_equipo', 'mac_equipo','latitud','longitud',
        'zoom','observacion'
    ];

    public function mensajeDisplay(){
       return $this->hasMany('App\MensajeDisplay','id_localizacion_display','id');
    }

}
