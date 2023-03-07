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
        $this->call(RolSeed::class);
        $this->call(UserAdminSeeder::class);
        $this->call(InterseccionListadoSeeder::class);
        $this->call(MenuGuardiaSeeder::class);
        $this->call(MenuMensajeSeeder::class);
        $this->call(CrearMensajeSeeder::class);
        $this->call(CentroMandoGestionDisplaySeeder::class);
        $this->call(SentidoPatronSeeder::class);
        $this->call(TipoIncidenciaSeed::class);
    }
}
