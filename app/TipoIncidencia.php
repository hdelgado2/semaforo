<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoIncidencia extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';
    protected $table = 'tipo_incidencia';
    protected $fillable = [
        "tipo"
    ];
}
