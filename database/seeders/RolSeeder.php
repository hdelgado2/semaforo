<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\roles;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        roles::create([
            'nombre_rol' => 'ADMINISTRADOR',
            'descripcion' => 'USUARIO CON TODOS LOS PERMISOS DEL SISTEMA',
            'activo' => true
        ]);

        roles::create([
            'nombre_rol' => 'SUPERVISOR',
            'descripcion' => 'USUARIO CON PERMISOS DE PANEL DE CONTROL Y REPORTES',
            'activo' => true
        ]);

        roles::create([
            'nombre_rol' => 'OPERADOR',
            'descripcion' => 'USUARIO CON PERMISO EN PANEL DE CONTROL',
            'activo' => true
        ]);
    }
}
