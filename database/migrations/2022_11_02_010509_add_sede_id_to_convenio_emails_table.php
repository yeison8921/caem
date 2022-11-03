<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSedeIdToConvenioEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('convenio_emails', function (Blueprint $table) {
            $table->foreignId('sede_id')->constrained('empresa_sedes')->onDelete('restrict')->after('convenio_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('convenio_emails', function (Blueprint $table) {
            $table->dropColumn('sede_id');
        });
    }
}
