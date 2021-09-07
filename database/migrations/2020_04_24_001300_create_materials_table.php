<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('materiales', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('empresa_id');
      $table->foreign('empresa_id')->references('id')->on('empresas');
      $table->string('descripcion', 140);
      $table->foreignId('categoria_id')->constrained('categorias');
      $table->boolean('color');
      $table->unsignedDecimal('alto', 5, 2)->nullable();
      $table->unsignedDecimal('ancho', 5, 2)->nullable();
      $table->unsignedDecimal('precio', 5, 2)->nullable();
      $table->boolean('uv')->default(0);
      $table->boolean('plastificado')->default(0);
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
    Schema::dropIfExists('materiales');
  }
}
