<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrearMensajeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crear_mensaje', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_mensaje');
            $table->string('motivo_mensaje');
            $table->string('mensaje');
            $table->boolean('estado_mensaje');
            $table->boolean('desactivar');
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
        Schema::dropIfExists('crear_mensaje');
    }
}
