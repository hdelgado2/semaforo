<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'menu';
    protected $fillable = ['nombre_menu','nombre_archivo','ruta_archivo','activo'];
}
