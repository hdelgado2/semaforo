<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(MenuSeeder::class);
        $this->call(InterseccionListadoSeeder::class);
        $this->call(MenuGuardiaSeeder::class);
        $this->call(MenuMensajeSeeder::class);
        $this->call(SentidoPatronSeeder::class);
    }
}
