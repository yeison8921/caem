<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmisionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emisiones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('unidad_consumo');
            $table->float('factor_emision_co2', 15, 8)->nullable();
            $table->string('unidad_factor_emision_co2')->nullable();
            $table->float('incertidumbre_co2_1', 15, 8)->nullable();
            $table->float('incertidumbre_co2_2', 15, 8)->nullable();
            $table->text('fuente_bibliografica_co2')->nullable();
            $table->float('factor_emision_ch4', 15, 8)->nullable();
            $table->string('unidad_factor_emision_ch4')->nullable();
            $table->float('incertidumbre_ch4_1', 15, 8)->nullable();
            $table->float('incertidumbre_ch4_2', 15, 8)->nullable();
            $table->text('fuente_bibliografica_ch4')->nullable();
            $table->string('tipo');
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
        Schema::dropIfExists('emisiones');
    }
}
