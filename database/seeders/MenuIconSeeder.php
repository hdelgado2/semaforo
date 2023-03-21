<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Menu;
use Illuminate\Support\Facades\DB;

class MenuIconSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        try{

            DB::beginTransaction();

            $getsion_usuario = Menu::where('nombre_menu','GESTION DE USUARIO')->first();
            $getsion_usuario->icon = 'fa-solid fa-user';
            $getsion_usuario->save();

            $getsion_roles = Menu::where('nombre_menu','GESTION DE ROLES')->first();
            $getsion_roles->icon = "fa-solid fa-address-book";
            $getsion_roles->save();

            $getsion_de_interseccion = Menu::where('nombre_menu','GESTION DE INTERSECCION')->first();
            $getsion_de_interseccion->icon = "fa-solid fa-road";
            $getsion_de_interseccion->save();

            $getsion_de_incidencias = Menu::where('nombre_menu','GESTION DE INCIDENCIAS')->first();
            $getsion_de_incidencias->icon = "fa-solid fa-triangle-exclamation";
            $getsion_de_incidencias->save();

            $panel_control = Menu::where('nombre_menu','PANEL DE CONTROL')->first();
            $panel_control->icon = "fa-solid fa-gamepad";
            $panel_control->save();

            $estadistica = Menu::where('nombre_menu','ESTADISTICA')->first();
            $estadistica->icon = "fa-solid fa-chart-simple";
            $estadistica->save();

            $cambio_de_clave = Menu::where('nombre_menu','CAMBIO DE CLAVE')->first();
            $cambio_de_clave->icon = "fa-solid fa-key";
            $cambio_de_clave->save();

            $listado_intersecciones = Menu::where('nombre_menu','LISTADO DE INTERSECCIONES')->first();
            $listado_intersecciones->icon = "fa-solid fa-list";
            $listado_intersecciones->save();

            $guardias = Menu::where('nombre_menu','GUARDIA')->first();
            $guardias->icon = "fa-solid fa-person-military-pointing";
            $guardias->save();

            $gestion_mensaje = Menu::where('nombre_menu','GESTIONAR MENSAJE')->first();
            $gestion_mensaje->icon = "fa-solid fa-envelope";
            $gestion_mensaje->save();

            $gestion_display = Menu::where('nombre_menu','GESTIONAR DISPLAYS')->first();
            $gestion_display->icon = "fa-solid fa-tv";
            $gestion_display->save();

            $centro_mando_display = Menu::where('nombre_menu','CENTRO DE MANDO DISPLAYS')->first();
            $centro_mando_display->icon = "fa-sharp fa-solid fa-computer";
            $centro_mando_display->save();

            DB::commit();

        }catch(\Exception $e){
            DB::rollBack();
            \Log::info('Ha ocurrido un error al correr seeder MenuIconSeeder: '.$e->getMessage());
        }
    }
}
