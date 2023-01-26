<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefrigerantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refrigerantes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('unidad_consumo');
            $table->float('factor_emision_compuestos_fluorados', 20, 6);
            $table->string('unidad_factor_emision_compuestos_fluorados');
            $table->float('incertidumbre_compuestos_fluorados_1', 20, 6);
            $table->float('incertidumbre_compuestos_fluorados_2', 20, 6);
            $table->text('fuente_bibliografica_compuestos_fluorados');
            $table->string('unidad_consumo_2');
            $table->float('factor_emision_compuestos_fluorados_2', 20, 6);
            $table->string('unidad_factor_emision_compuestos_fluorados_2');
            $table->float('incertidumbre_compuestos_fluorados_1_2', 20, 6);
            $table->float('incertidumbre_compuestos_fluorados_2_2', 20, 6);
            $table->text('fuente_bibliografica_compuestos_fluorados_2');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the miSgrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('refrigerantes');
    }
}
