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
            $table->tinyInteger('datos_proveedores');
            $table->tinyInteger('fuentes_moviles');
            $table->tinyInteger('actividad_agricola');
            $table->tinyInteger('huella_base');

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
            $table->tinyInteger('efecto_invernadero');
            $table->tinyInteger('sumideros');
            $table->tinyInteger('informacion_mensual');
            $table->tinyInteger('diagrama_procesos');
            $table->tinyInteger('areas_sumideros');
            $table->tinyInteger('informacion_centralizada');
            $table->tinyInteger('soportes_consumos');
            $table->tinyInteger('informacion_anio');
            $table->tinyInteger('estimaciones_consumos');
            $table->tinyInteger('consumos_energeticos');
            $table->tinyInteger('sustento_metodologico');
            $table->tinyInteger('compartira_reporte');
            $table->tinyInteger('toma_decisiones');
            $table->foreignId('unidad_id')->nullable()->constrained('parametros')->onDelete('restrict');
            $table->integer('anio_inicio')->nullable();
            $table->integer('mes_inicio')->nullable();
            $table->integer('estado')->nullable();
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
