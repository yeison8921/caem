<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEstaAprobadoToInformacionEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('informacion_empresas', function (Blueprint $table) {
            $table->date('fecha_aprobacion')->nullable()->after('estado');
            $table->boolean('esta_aprobado')->default(false)->after('fecha_aprobacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('informacion_empresas', function (Blueprint $table) {
            //
        });
    }
}
