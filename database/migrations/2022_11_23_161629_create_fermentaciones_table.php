<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFermentacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fermentaciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('unidad_consumo');
            $table->float('factor_emision_ch4', 12, 10);
            $table->string('unidad_factor_emision_ch4');
            $table->float('incertidumbre_ch4_1', 6, 5);
            $table->float('incertidumbre_ch4_2', 6, 5);
            $table->text('fuente_bibliografica_ch4');
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
        Schema::dropIfExists('fermentaciones');
    }
}
