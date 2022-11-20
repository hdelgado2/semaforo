<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permisos extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = 'pgsql';
    protected $table = 'permisos';
    protected $fillable = ['usuario','ruta','nivel'];
}
