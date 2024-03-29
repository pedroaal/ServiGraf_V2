<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbonosTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('abonos', function (Blueprint $table) {
      $table->id();
      $table->foreignId('pedido_id')->constrained('pedidos')->onDelete('cascade');
      $table->date('fecha');
      $table->unsignedInteger('usuario_id');
      $table->foreign('usuario_id')->references('cedula')->on('usuarios')->onDelete('cascade');
      $table->string('forma_pago');
      $table->decimal('valor', 8, 2)->default(0.0);
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
    Schema::dropIfExists('abonos');
  }
}
