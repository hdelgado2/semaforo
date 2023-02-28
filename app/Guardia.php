<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guardia extends Model
{
    use HasFactory;
    protected $table = 'guardias';
    protected $fillable = [
        'usuarios_id', 'fecha_inicio', 'fecha_fin', 'hora_inicio','hora_fin'
    ];
    protected $appends = ['horario'];

    public function usuario()
    {
        return $this->belongsTo('App\User','usuarios_id');
    }

    public function getHorarioAttribute()
    {
        return $this->fecha_inicio.'('.$this->hora_inicio.')'.' - '.$this->fecha_fin.'('.$this->hora_fin.')';
    }
}
