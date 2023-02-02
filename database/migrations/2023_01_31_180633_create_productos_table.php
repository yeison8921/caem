<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('unidad_consumo');
            $table->float('factor_emision_co2', 20, 6);
            $table->string('unidad_factor_emision_co2');
            $table->float('incertidumbre_co2_1', 20, 6);
            $table->float('incertidumbre_co2_2', 20, 6);
            $table->text('fuente_bibliografica_co2');
            $table->string('tipo');
            $table->string('subtipo');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
