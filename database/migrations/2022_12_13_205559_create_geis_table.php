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
            $table->float('ar6pcg_gwp');
            $table->float('ar5pcg_gwp');
            $table->float('ar4pcg_gwp');
            $table->float('srpcg_gwp');
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
