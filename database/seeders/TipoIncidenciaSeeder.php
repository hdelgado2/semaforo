<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\TipoIncidencia;

class TipoIncidenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoIncidencia::create([
            'tipo' => 'FALLA ELÉCTRICA'
        ]);

        TipoIncidencia::create([
            'tipo' => 'FALLA DE CONEXIÓN'
        ]);

        TipoIncidencia::create([
            'tipo' => 'ACCIDENTE DE TRÁNSITO'
        ]);

    }
}
