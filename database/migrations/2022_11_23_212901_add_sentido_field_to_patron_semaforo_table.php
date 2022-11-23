<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSentidoFieldToPatronSemaforoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patron_semaforo', function (Blueprint $table) {
            $table->string('sentido')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patron_semaforo', function (Blueprint $table) {
            $table->dropColumn('sentido');
        });
    }
}
