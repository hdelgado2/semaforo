<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatronSemaforoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patron_semaforo', function (Blueprint $table) {
            $table->id();
            $table->integer('intersecciones_id');
            $table->string('direccion')->nullable();
            $table->integer('rojo')->default(0);
            $table->integer('rojo_cruce_izq')->default(0);
            $table->integer('rojo_cruce_der')->default(0);
            $table->integer('amarillo')->default(0);
            $table->integer('amarillo_cruce_izq')->default(0);
            $table->integer('amarillo_cruce_der')->default(0);
            $table->integer('verde')->default(0);
            $table->integer('verde_cruce_izq')->default(0);
            $table->integer('verde_cruce_der')->default(0);
            $table->string('sentido')->nullable();
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
        Schema::dropIfExists('patron_semaforo');
    }
}
