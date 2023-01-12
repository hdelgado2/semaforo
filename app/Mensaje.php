<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    use HasFactory;
    public $table = "crear_mensajes";
    public $fillable = ['tipo_mensaje','motivo_mensaje','mensaje','estado_mensaje'];
}
