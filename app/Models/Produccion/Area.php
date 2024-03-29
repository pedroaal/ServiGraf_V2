<?php

namespace App\Models\Produccion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;

class Area extends Model
{
  use SoftDeletes, CascadeSoftDeletes;

  protected $table = 'areas';

  protected $fillable = [
    'empresa_id', 'area', 'orden'
  ];

  protected $hidden = [
    'created_at', 'updated_at',
  ];

  protected $cascadeDeletes = ['procesos'];

  /**
   * Get all of the procesos for the Area
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function procesos()
  {
    return $this->hasMany(Proceso::class);
  }
}
