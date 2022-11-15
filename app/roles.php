<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class roles extends Model
{
    use SoftDeletes;
    protected $table = 'roles';
    protected $fillable = ['nombre_rol','descripcion','activo'];
    
}
