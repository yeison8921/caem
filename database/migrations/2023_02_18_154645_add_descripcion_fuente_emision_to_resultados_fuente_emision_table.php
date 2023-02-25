<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescripcionFuenteEmisionToResultadosFuenteEmisionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resultados_fuente_emision', function (Blueprint $table) {
            $table->text('descripcion_fuente_emision')->nullable()->after('fuente_emision');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resultados_fuente_emision', function (Blueprint $table) {
            $table->dropColumn('descripcion_fuente_emision');
        });
    }
}
