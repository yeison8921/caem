<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFertilizantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fertilizantes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('unidad_consumo');
            $table->float('factor_emision_co2', 15, 8)->nullable();
            $table->string('unidad_factor_emision_co2')->nullable();
            $table->float('incertidumbre_co2_1', 15, 8)->nullable();
            $table->float('incertidumbre_co2_2', 15, 8)->nullable();
            $table->text('fuente_bibliografica_co2')->nullable();
            $table->float('factor_emision_n2o', 15, 8)->nullable();
            $table->string('unidad_factor_emision_n2o')->nullable();
            $table->float('incertidumbre_n2o_1', 15, 8)->nullable();
            $table->float('incertidumbre_n2o_2', 15, 8)->nullable();
            $table->text('fuente_bibliografica_n2o')->nullable();
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
        Schema::dropIfExists('fertilizantes');
    }
}
