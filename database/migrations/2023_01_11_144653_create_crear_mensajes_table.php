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
        Schema::create('crear_mensaje', function (Blueprint $table) {
            $table->id();
            $table->string("tipo_mensaje");
            $table->string("motivo_mensaje")->nullable();
            $table->string("mensaje");
            $table->boolean("estado_mensaje")->default(true);
            $table->boolean("desactivar")->default(false);
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
