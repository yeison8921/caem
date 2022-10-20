<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasTemporalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas_temporales', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('nit');
            $table->string('telefono');
            $table->integer('codigo_ciiu_id');
            $table->integer('sector_id');
            $table->integer('empleado_id');
            $table->integer('tamano_id');
            $table->integer('departamento_id');
            $table->integer('ciudad_id');
            $table->integer('usuario_creacion_id');
            $table->string('nombre_sede');
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
        Schema::dropIfExists('empresas_temporales');
    }
}
