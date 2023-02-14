<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrearMensajesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crear_mensajes', function (Blueprint $table) {
            $table->id();
            $table->string("tipo_mensaje");
            $table->string("motivo_mensaje")->nullable();
            $table->string("mensaje");
            $table->boolean("estado_mensaje")->default(true);
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
        Schema::dropIfExists('crear_mensajes');
    }
}
