<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipoToViajesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('viajes', function (Blueprint $table) {
            $table->string('tipo')->after('fuente_bibliografica_co2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('viajes', function (Blueprint $table) {
            $table->dropColumn('tipo');
        });
    }
}
