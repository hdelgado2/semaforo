<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocalizacionDisplayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('localizacion_display', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_display');
            $table->string('ip_equipo');
            $table->string('mac_equipo');
            $table->string('latitud');
            $table->string('longitud');
            $table->integer('zoom');
            $table->string('observacion');
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
        Schema::dropIfExists('localizacion_display');
    }
}
