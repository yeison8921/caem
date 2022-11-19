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
            $table->integer('valor_huella_base');
            $table->tinyInteger('huella_comparativo');
            $table->integer('valor_huella_comparativo');
            $table->text('alcances_huella');
            $table->tinyInteger('priorizacion');
            $table->tinyInteger('indicador');
            $table->tinyInteger('verificacion_interna');
            $table->tinyInteger('optimizacion_procesos');
            $table->tinyInteger('verificacion_tercero');
            $table->tinyInteger('declaracion_conformidad_tercero');
            $table->tinyInteger('acciones_mejora');
            $table->tinyInteger('metas_mitigacion');
            $table->integer('meta_reduccion');
            $table->integer('anio_meta');
            $table->integer('anio_proyeccion_meta');
            $table->tinyInteger('meta_alineada');
            $table->tinyInteger('metodologias');
            $table->string('otra_metodologia')->nullable();
            $table->tinyInteger('seguimiento_cumplimiento');
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
