<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterseccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intersecciones', function (Blueprint $table) {
            $table->id();
            $table->string('interseccion');
            $table->string('ip_equipo')->nullable();
            $table->string('mac_equipo')->nullable();
            $table->string('latitud');
            $table->string('longitud');
            $table->integer('zoom')->nullable();
            $table->longText('observacion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('intersecciones');
    }
}
