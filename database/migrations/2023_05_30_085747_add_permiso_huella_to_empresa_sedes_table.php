<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPermisoHuellaToEmpresaSedesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empresa_sedes', function (Blueprint $table) {
            $table->integer('permiso_huella')->default('1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('empresa_sedes', function (Blueprint $table) {
            $table->dropColumn('permiso_huella');
        });
    }
}
