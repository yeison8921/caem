<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('nit');
            $table->string('telefono');
            $table->foreignId('codigo_ciiu_id')->constrained('parametros')->onDelete('restrict');
            $table->foreignId('sector_id')->constrained('parametros')->onDelete('restrict');
            $table->foreignId('empleado_id')->constrained('parametros')->onDelete('restrict');
            $table->foreignId('tamano_id')->constrained('parametros')->onDelete('restrict');
            $table->foreignId('departamento_id')->constrained('parametros')->onDelete('restrict');
            $table->foreignId('ciudad_id')->constrained('parametros')->onDelete('restrict');
            $table->foreignId('usuario_actualizo_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('convenio_id')->constrained('convenios')->onDelete('restrict');
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
        Schema::dropIfExists('empresas');
    }
}
