<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Menu;

class MenuAuditoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Menu::create([
            'nombre_menu' => 'GUARDIA',
            'nombre_archivo' => 'A',
            'ruta_archivo' => 'guardia',
            'activo' => true
        ]);
    }
}
