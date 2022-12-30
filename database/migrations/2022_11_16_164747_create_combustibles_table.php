<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCombustiblesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('combustibles', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('unidad_consumo');
            $table->float('factor_emision_co2', 20, 6);
            $table->string('unidad_factor_emision_co2');
            $table->float('incertidumbre_co2_1', 20, 6);
            $table->float('incertidumbre_co2_2', 20, 6);
            $table->string('fuente_bibliografica_co2');

            //Fuentes fijas
            $table->float('factor_emision_ch4g_fuente_fija', 20, 6);
            $table->float('factor_emision_ch4kg_fuente_fija', 20, 6);
            $table->string('unidad_factor_emision_ch4_fuente_fija');
            $table->float('incertidumbre_ch4_1_fuente_fija', 20, 6);
            $table->float('incertidumbre_ch4_2_fuente_fija', 20, 6);
            $table->string('fuente_bibliografica_ch4_fuente_fija');

            $table->float('factor_emision_n2og_fuente_fija', 20, 6);
            $table->float('factor_emision_n2okg_fuente_fija', 20, 6);
            $table->string('unidad_factor_emision_n2o_fuente_fija');
            $table->float('incertidumbre_n2o_1_fuente_fija', 20, 6);
            $table->float('incertidumbre_n2o_2_fuente_fija', 20, 6);
            $table->string('fuente_bibliografica_n2o_fuente_fija');

            //Fuentes móviles
            $table->float('factor_emision_ch4g_fuente_movil', 20, 6);
            $table->float('factor_emision_ch4kg_fuente_movil', 20, 6);
            $table->string('unidad_factor_emision_ch4_fuente_movil');
            $table->float('incertidumbre_ch4_1_fuente_movil', 20, 6);
            $table->float('incertidumbre_ch4_2_fuente_movil', 20, 6);
            $table->string('fuente_bibliografica_ch4_fuente_movil');

            $table->float('factor_emision_n2og_fuente_movil', 20, 6);
            $table->float('factor_emision_n2okg_fuente_movil', 20, 6);
            $table->string('unidad_factor_emision_n2o_fuente_movil');
            $table->float('incertidumbre_n2o_1_fuente_movil', 20, 6);
            $table->float('incertidumbre_n2o_2_fuente_movil', 20, 6);
            $table->string('fuente_bibliografica_n2o_fuente_movil');

            $table->string('tipo');
            $table->integer('biogenico');

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
        Schema::dropIfExists('combustibles');
    }
}
