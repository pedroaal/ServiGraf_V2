<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('usuarios', function (Blueprint $table) {
      // $table->id();
      //datos de usuario
      $table->unsignedInteger('cedula')->unique();
      $table->foreign('cedula')->references('cedula')->on('nomina')->onDelete('cascade');
      //datos de validacion
      $table->rememberToken();
      $table->unsignedBigInteger('empresa_id');
      $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');
      $table->string('usuario')->unique();
      $table->string('password');
      $table->foreignId('perfil_id')->constrained('perfiles')->onDelete('cascade');
      //permisos adicionales
      $table->boolean('status')->default(1);
      $table->boolean('reservarot')->default(0);
      $table->boolean('libro')->default(0);
      $table->boolean('utilidad')->default(1);
      $table->boolean('is_superadmin')->default(0);
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
    Schema::dropIfExists('usuarios');
  }
}
