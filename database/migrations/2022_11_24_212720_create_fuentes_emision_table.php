<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuentesEmisionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fuentes_emision', function (Blueprint $table) {
            $table->id();
            $table->morphs('fuentetable');
            $table->string("tipo");
            $table->string("fuente_emision")->nullable();
            $table->text("descripcion")->nullable();
            $table->text("informacion_adicional")->nullable();
            // $table->float('dato_mes_1', 15, 8)->nullable();
            $table->foreignId('subproceso_id')->nullable()->constrained('subprocesos')->onDelete('restrict');
            $table->foreignId('informacion_empresa_id')->constrained('informacion_empresas')->onDelete('restrict');
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
        Schema::dropIfExists('fuentes_emision');
    }
}
