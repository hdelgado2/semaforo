<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auditoria extends Model
{
    use HasFactory;
    protected $table = 'auditoria';
    protected $fillable = [
        'usuarios_id', 'ip_origen', 'fecha','hora','evento',
        'descripcion',
    ];

    public function usuario()
    {
        return $this->belongsTo('App\User','usuarios_id');
    }
}
