<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventarioAlarmasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventario_alarmas', function (Blueprint $table) {
            $table->id();
            $table->string('nombreEquipo');
            $table->integer('cantidad');
            $table->foreignId('informe_id')->references('id')->on('informes');
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
        Schema::dropIfExists('inventario_alarmas');
    }
}
