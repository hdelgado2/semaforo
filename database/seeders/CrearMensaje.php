<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Menu;

class CrearMensaje extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
       Menu::create([
            'nombre_menu' => 'GESTIONAR MENSAJE',
            'nombre_archivo' => 'GM',
            'ruta_archivo' => 'gestionar_mensaje',
            'activo' => true
        ]);
    }
}
