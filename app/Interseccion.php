<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Interseccion extends Model
{
    use HasFactory;
  //  use SoftDeletes;

    protected $table = 'intersecciones';
   // public $timestamps = false;  
    protected $fillable = [
        'interseccion', 'ip_equipo', 'mac_equipo','latitud','longitud',
        'zoom','observacion'
    ];

    public function patrones(){
       return $this->hasMany('App\PatronSemaforo','intersecciones_id','id');
    }


}
