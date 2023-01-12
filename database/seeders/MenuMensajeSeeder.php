<?php

namespace Database\Seeders;
  
use Illuminate\Database\Seeder;
use App\Menu;

class MenuMensajeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Menu::create([
            'nombre_menu' => 'MENSAJES',
            'nombre_archivo' => 'M',
            'ruta_archivo' => 'mensajes',
            'activo' => true
        ]);

    }
}
