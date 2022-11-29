<?php

namespace Database\Seeders;
  
use Illuminate\Database\Seeder;
use App\Menu;

class InterseccionListadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Menu::create([
            'nombre_menu' => 'LISTADO DE INTERSECCIONES',
            'nombre_archivo' => 'LI',
            'ruta_archivo' => 'lintersecciones',
            'activo' => true
        ]);

    }
}
