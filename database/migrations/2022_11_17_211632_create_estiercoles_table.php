<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstiercolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estiercoles', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('unidad_consumo');
            $table->float('factor_emision_ch4', 8, 4);
            $table->string('unidad_factor_emision_ch4');
            $table->float('incertidumbre_ch4_1', 6, 5);
            $table->float('incertidumbre_ch4_2', 9, 7);
            $table->string('fuente_bibliografica_ch4');
            $table->float('factor_emision_n2o', 8, 4);
            $table->string('unidad_factor_emision_n2o');
            $table->float('incertidumbre_n2o_1', 6, 5);
            $table->float('incertidumbre_n2o_2', 6, 5);
            $table->string('fuente_bibliografica_n2o');
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
        Schema::dropIfExists('estiercoles');
    }
}
