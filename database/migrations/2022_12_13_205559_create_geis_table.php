<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geis', function (Blueprint $table) {
            $table->id();
            $table->string('gei');
            $table->integer('ar5pcg_gwp');
            $table->integer('ar4pcg_gwp');
            $table->integer('srpcg_gwp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('geis');
    }
}
