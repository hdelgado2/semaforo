<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\User;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nombre' => 'admin',
            'apellido' => 'admin',
            'roles_id' => 1,
            'baneado' => false,
            'intentos_fallidos' => 0,
            'password' => md5('secuencia'),
            'cedula' => '123456',
            'login' => 'admin'
        ]);
    }
}
