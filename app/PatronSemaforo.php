<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatronSemaforo extends Model
{
    use HasFactory;
    //use SoftDeletes;

    protected $table = 'patron_semaforo';
    protected $fillable = [
        'intersecciones_id', 'direccion', 'rojo','rojo_cruce_izq','rojo_cruce_der',
        'amarillo','amarillo_cruce_izq','amarillo_cruce_der','verde','verde_cruce_izq','verde_cruce_der'
    ];
}
