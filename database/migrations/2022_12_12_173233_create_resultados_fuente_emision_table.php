<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultadosFuenteEmisionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resultados_fuente_emision', function (Blueprint $table) {
            $table->id();
            $table->morphs('fuentetable');
            $table->string("tipo");
            $table->string("fuente_emision")->nullable();
            $table->float('dato_1', 20, 6)->nullable();
            $table->float('dato_2', 20, 6)->nullable();
            $table->float('dato_3', 20, 6)->nullable();
            $table->float('dato_4', 20, 6)->nullable();
            $table->float('dato_5', 20, 6)->nullable();
            $table->float('dato_6', 20, 6)->nullable();
            $table->float('dato_7', 20, 6)->nullable();
            $table->float('dato_8', 20, 6)->nullable();
            $table->float('dato_9', 20, 6)->nullable();
            $table->float('dato_10', 20, 6)->nullable();
            $table->float('dato_11', 20, 6)->nullable();
            $table->float('dato_12', 20, 6)->nullable();

            $table->float('total', 20, 6)->nullable();
            $table->integer('numero_datos')->nullable();
            $table->float('promedio', 20, 6)->nullable();
            $table->float('desviacion_estandar', 20, 6)->nullable();
            $table->float('factor_t', 20, 6)->nullable();
            $table->float('incertidumbre_sistematica_adicional', 20, 6)->nullable();
            $table->float('incertidumbre_datos', 20, 6)->nullable();

            $table->float('factor_emision_co2', 20, 6)->nullable();
            $table->string('unidad_factor_emision_co2')->nullable();
            $table->float('incertidumbre_factor_emision_co2', 20, 6)->nullable();
            $table->float('emision_co2_ton', 20, 6)->nullable();
            $table->float('emision_co2_ton_eq', 20, 6)->nullable();
            $table->float('incertidumbre_emision_co2', 20, 6)->nullable();
            $table->float('columna_auxiliar_co2', 20, 6)->nullable();

            $table->float('factor_emision_ch4', 20, 6)->nullable();
            $table->string('unidad_factor_emision_ch4')->nullable();
            $table->float('incertidumbre_factor_emision_ch4', 20, 6)->nullable();
            $table->float('emision_ch4_ton', 20, 6)->nullable();
            $table->float('emision_ch4_ton_eq', 20, 6)->nullable();
            $table->float('incertidumbre_emision_ch4', 20, 6)->nullable();
            $table->float('columna_auxiliar_ch4', 20, 6)->nullable();

            $table->float('factor_emision_n2o', 20, 6)->nullable();
            $table->string('unidad_factor_emision_n2o')->nullable();
            $table->float('incertidumbre_factor_emision_n2o', 20, 6)->nullable();
            $table->float('emision_n2o_ton', 20, 6)->nullable();
            $table->float('emision_n2o_ton_eq', 20, 6)->nullable();
            $table->float('incertidumbre_emision_n2o', 20, 6)->nullable();
            $table->float('columna_auxiliar_n2o', 20, 6)->nullable();

            $table->float('factor_emision_compuestos_fluorados', 20, 6)->nullable();
            $table->string('unidad_factor_emision_compuestos_fluorados')->nullable();
            $table->float('incertidumbre_factor_emision_compuestos_fluorados', 20, 6)->nullable();
            $table->float('emision_compuestos_fluorados_ton', 20, 6)->nullable();
            $table->float('emision_compuestos_fluorados_ton_eq', 20, 6)->nullable();
            $table->float('incertidumbre_emision_compuestos_fluorados', 20, 6)->nullable();
            $table->float('columna_auxiliar_compuestos_fluorados', 20, 6)->nullable();

            $table->float('factor_emision_sf6', 20, 6)->nullable();
            $table->string('unidad_factor_emision_sf6')->nullable();
            $table->float('incertidumbre_factor_emision_sf6', 20, 6)->nullable();
            $table->float('emision_sf6_ton', 20, 6)->nullable();
            $table->float('emision_sf6_ton_eq', 20, 6)->nullable();
            $table->float('incertidumbre_emision_sf6', 20, 6)->nullable();
            $table->float('columna_auxiliar_sf6', 20, 6)->nullable();

            $table->float('factor_emision_nf3', 20, 6)->nullable();
            $table->string('unidad_factor_emision_nf3')->nullable();
            $table->float('incertidumbre_factor_emision_nf3', 20, 6)->nullable();
            $table->float('emision_nf3_ton', 20, 6)->nullable();
            $table->float('emision_nf3_ton_eq', 20, 6)->nullable();
            $table->float('incertidumbre_emision_nf3', 20, 6)->nullable();
            $table->float('columna_auxiliar_nf3', 20, 6)->nullable();

            $table->float('huella_carbono', 20, 6)->nullable();
            $table->float('incertidumbre_fuente', 20, 6)->nullable();

            $table->foreignId('informacion_empresa_id')->constrained('empresas')->onDelete('restrict');
            $table->foreignId('empresa_id')->constrained('empresas')->onDelete('restrict');
            $table->foreignId('sede_id')->constrained('empresa_sedes')->onDelete('restrict');

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
        Schema::dropIfExists('resultados_fuente_emision');
    }
}
