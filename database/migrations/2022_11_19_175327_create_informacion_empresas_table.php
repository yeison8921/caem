<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformacionEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informacion_empresas', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('datos_proveedores')->nullable();
            $table->tinyInteger('fuentes_moviles')->nullable();
            $table->tinyInteger('actividad_agricola')->nullable();
            $table->tinyInteger('huella_base')->nullable();
            $table->integer('valor_huella_base')->nullable();
            $table->tinyInteger('huella_comparativo')->nullable();
            $table->integer('valor_huella_comparativo')->nullable();
            $table->text('alcances_huella')->nullable();
            $table->tinyInteger('priorizacion')->nullable();
            $table->tinyInteger('indicador')->nullable();
            $table->tinyInteger('verificacion_interna')->nullable();
            $table->tinyInteger('optimizacion_procesos')->nullable();
            $table->tinyInteger('verificacion_tercero')->nullable();
            $table->tinyInteger('declaracion_conformidad_tercero')->nullable();
            $table->tinyInteger('acciones_mejora')->nullable();
            $table->tinyInteger('metas_mitigacion')->nullable();
            $table->integer('meta_reduccion')->nullable();
            $table->integer('anio_meta')->nullable();
            $table->integer('anio_proyeccion_meta')->nullable();
            $table->tinyInteger('meta_alineada')->nullable();
            $table->tinyInteger('metodologia')->nullable();
            $table->string('otra_metodologia')->nullable();
            $table->tinyInteger('seguimiento_cumplimiento')->nullable();
            $table->tinyInteger('efecto_invernadero')->nullable();
            $table->tinyInteger('sumideros')->nullable();
            $table->tinyInteger('informacion_mensual')->nullable();
            $table->tinyInteger('diagrama_procesos')->nullable();
            $table->tinyInteger('areas_sumideros')->nullable();
            $table->tinyInteger('informacion_centralizada')->nullable();
            $table->tinyInteger('soportes_consumos')->nullable();
            $table->tinyInteger('informacion_anio')->nullable();
            $table->tinyInteger('estimaciones_consumos')->nullable();
            $table->tinyInteger('consumos_energeticos')->nullable();
            $table->tinyInteger('sustento_metodologico')->nullable();
            $table->tinyInteger('compartira_reporte')->nullable();
            $table->tinyInteger('toma_decisiones')->nullable();
            $table->integer('unidades_producidas')->nullable();
            $table->integer('anio_inicio')->nullable();
            $table->string('mes_inicio')->nullable();
            $table->integer('estado')->default(1);
            $table->foreignId('usuario_creacion_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('empresa_id')->constrained('empresas')->onDelete('restrict');
            $table->foreignId('sede_id')->constrained('empresa_sedes')->onDelete('restrict');
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
        Schema::dropIfExists('informacion_empresas');
    }
}
