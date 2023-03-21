<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMensajesDisplayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mensajes_display', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_crear_mensaje')->constrained('crear_mensaje');
            $table->foreignId('id_localizacion_display')->constrained('localizacion_display');
            $table->string('tipo_programacion')->nullable();
            $table->string('etiqueta_proceso')->nullable();
            $table->string('tiempo');
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
        Schema::dropIfExists('mensajes_display');
    }
}
