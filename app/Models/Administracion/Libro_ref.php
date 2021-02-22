<?php

namespace App\Models\Administracion;

use Illuminate\Database\Eloquent\Model;

class Libro_ref extends Model
{
  protected $table = 'libro_refs';

  protected $fillable = [
    'empresa_id', 'usuario_id', 'referencia', 'descripcion'
  ];

  public $attributes = [
  ];
}
