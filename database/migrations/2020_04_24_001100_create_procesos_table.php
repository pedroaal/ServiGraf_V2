<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcesosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procesos', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->unsignedBigInteger('empresa_id');
            $table->foreign('empresa_id')->references('id')->on('empresas');
            $table->unsignedMediumInteger('area_id');
            $table->foreign('area_id')->references('id')->on('areas');
            $table->foreignId('parent_id')->references('id')->on('procesos');
            $table->string('servicio', 140);
            $table->unsignedDecimal('meta', 7, 2)->default(0.00);
            $table->time('tmaquina', 0)->nullable();
            $table->time('toperador', 0)->nullable();
            $table->boolean('tipo')->default(1); //interno o externo
            $table->boolean('seguimiento')->default(0);
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
        Schema::dropIfExists('procesos');
    }
}