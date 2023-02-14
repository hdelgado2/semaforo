<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    use HasFactory;

    protected $table = 'crear_mensaje';
    protected $fillable = ['tipo_mensaje','motivo_mensaje','mensaje','estado_mensaje','desactivar'];

}
