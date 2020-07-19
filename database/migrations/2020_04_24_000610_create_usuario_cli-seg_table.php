<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuarioCliSegTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DDBBusuarios')->create('usuario_cli-seg', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->timestamps();
            $table->unsignedInteger('usuario_id');
            $table->foreign('usuario_id')->references('cedula')->on('usuarios');
            $table->unsignedMediumInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes_v2.clientes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('DDBBusuarios')->dropIfExists('usuario_cli-seg');
    }
}
