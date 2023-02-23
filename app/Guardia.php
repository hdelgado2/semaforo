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

    public function usuario()
    {
        return $this->belongsTo('App\User','usuarios_id');
    }
}
