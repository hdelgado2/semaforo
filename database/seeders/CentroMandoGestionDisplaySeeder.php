<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Menu;


class CentroMandoGestionDisplaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
          Menu::create([
            'nombre_menu' => 'GESTIONAR DISPLAYS',
            'nombre_archivo' => 'GD',
            'ruta_archivo' => 'gestionar_displays',
            'activo' => true
        ]);

            Menu::create([
            'nombre_menu' => 'CENTRO DE MANDO DISPLAYS',
            'nombre_archivo' => 'GMD',
            'ruta_archivo' => 'centro_mando_displays',
            'activo' => true
        ]);


    }
}
