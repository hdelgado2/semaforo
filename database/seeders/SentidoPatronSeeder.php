<?php

namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
use App\PatronSemaforo;

class SentidoPatronSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     
        $patrones = PatronSemaforo::get();

        foreach( $patrones as $patron ){

            $word   = "";
            $direccion = $patron->direccion;

            if (str_contains( $direccion , 'NORTE')) { 
                $word = 'NORTE';
            }
            else if (str_contains( $direccion , 'SUR')) { 
                $word = 'SUR';
            }
            else if(str_contains( $direccion , 'OESTE')) { 
                $word = 'OESTE';
            }
            else if(str_contains( $direccion , 'ESTE')) { 
                $word = 'ESTE';
            }

            $patron->sentido = $word;
            $patron->save();
        }
        
    }
}
