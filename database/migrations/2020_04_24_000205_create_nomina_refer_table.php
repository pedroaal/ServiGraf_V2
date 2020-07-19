<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNominaReferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DDBBempresas')->create('nomina_refer', function (Blueprint $table) {
            $table->unsignedMediumInteger('id');
            $table->timestamps();
            $table->unsignedBigInteger('empresa_id');
            $table->foreign('empresa_id')->references('id')->on('empresas_v2.empresas');
            $table->unsignedInteger('nomina_id');
            $table->foreign('nomina_id')->references('cedula')->on('empresas_v2.nomina');
            $table->boolean('tipo_refer');
            $table->string('empresa', 50)->nullable($value = true);
            $table->string('contacto', 100);
            $table->unsignedInteger('telefono');
            $table->string('afinidad', 50);
            $table->date('inicio_labor')->nullable($value = true);
            $table->date('fin_labor')->nullable($value = true);
            $table->string('cargo', 50);
            $table->string('razon_separacion', 250)->nullable($value = true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('DDBBempresas')->dropIfExists('nomina_refer');
    }
}
