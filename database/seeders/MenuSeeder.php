<?php

use Illuminate\Database\Seeder;
use App\Menu;
class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Menu::create([
            'nombre_menu' => 'GESTION DE USUARIO',
            'nombre_archivo' => 'GU',
            'ruta_archivo' => 'guser',
            'activo' => true
        ]);

        Menu::create([
            'nombre_menu' => 'GESTION DE ROLES',
            'nombre_archivo' => 'GR',
            'ruta_archivo' => 'groles',
            'activo' => true
        ]);

        Menu::create([
            'nombre_menu' => 'GESTION DE INTERSECCION',
            'nombre_archivo' => 'GI',
            'ruta_archivo' => 'ginterseccion',
            'activo' => true
        ]);

        Menu::create([
            'nombre_menu' => 'GESTION DE INCIDENCIAS',
            'nombre_archivo' => 'INC',
            'ruta_archivo' => 'ginterseccion',
            'activo' => true
        ]);

        Menu::create([
            'nombre_menu' => 'PANEL DE CONTROL',
            'nombre_archivo' => 'PC',
            'ruta_archivo' => 'pControl',
            'activo' => true
        ]);

        Menu::create([
            'nombre_menu' => 'ESTADISTICA',
            'nombre_archivo' => 'EST',
            'ruta_archivo' => 'estadistica',
            'activo' => true
        ]);

        Menu::create([
            'nombre_menu' => 'REPORTE AUDITORIA',
            'nombre_archivo' => 'RA',
            'ruta_archivo' => 'rAuditoria',
            'activo' => true
        ]);

        Menu::create([
            'nombre_menu' => 'CAMBIO DE CLAVE',
            'nombre_archivo' => 'CC',
            'ruta_archivo' => 'cClave',
            'activo' => true
        ]);
    }
}
