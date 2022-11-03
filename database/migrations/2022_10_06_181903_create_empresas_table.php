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
            $table->string('nombre')->nullable();
            $table->string('nit');
            $table->string('telefono')->nullable();
            $table->foreignId('codigo_ciiu_id')->nullable()->constrained('parametros')->onDelete('restrict');
            $table->foreignId('sector_id')->nullable()->constrained('parametros')->onDelete('restrict');
            $table->foreignId('empleado_id')->nullable()->constrained('parametros')->onDelete('restrict');
            $table->foreignId('tamano_id')->nullable()->constrained('parametros')->onDelete('restrict');
            $table->foreignId('usuario_actualizo_id')->nullable()->constrained('users')->onDelete('restrict');
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
