<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    use HasFactory;
    protected $table = 'incidencias';
    protected $fillable = [
        'tipo_incidencias_id', 'guardias_id', 'intersecciones_id','descripcion','accion',
        'solucion','observacion','usuario_id'
    ];

    public function tipo()
    {
        return $this->belongsTo('App\TipoIncidencia','tipo_incidencias_id','id');
    }

    public function interseccion()
    {
        return $this->belongsTo('App\Interseccion','intersecciones_id','id');
    }

    public function guardia()
    {
        return $this->belongsTo('App\Guardia','guardias_id','id');
    }
}
