<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAislamientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aislamientos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('unidad_consumo_1');
            $table->float('factor_emision_co2_1');
            $table->string('unidad_factor_emision_co2_1');
            $table->float('incertidumbre_co2_1_1', 6, 5);
            $table->float('incertidumbre_co2_1_2', 6, 5);
            $table->text('fuente_bibliografica_co2_1');
            $table->string('unidad_consumo_2');
            $table->float('factor_emision_co2_2');
            $table->string('unidad_factor_emision_co2_2');
            $table->float('incertidumbre_co2_2_1', 6, 5);
            $table->float('incertidumbre_co2_2_2', 6, 5);
            $table->text('fuente_bibliografica_co2_2');
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
        Schema::dropIfExists('aislamientos');
    }
}