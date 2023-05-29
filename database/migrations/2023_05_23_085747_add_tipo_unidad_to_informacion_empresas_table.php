<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipoUnidadToInformacionEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('informacion_empresas', function (Blueprint $table) {
            $table->string('tipo_unidad')->after('unidades_producidas')->nullable();
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
            $table->dropColumn('tipo_unidad');
        });
    }
}
