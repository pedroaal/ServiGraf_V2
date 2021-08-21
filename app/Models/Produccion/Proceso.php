<?php

namespace App\Models\Produccion;

use Illuminate\Database\Eloquent\Model;

class Proceso extends Model
{
    protected $table = 'procesos';

    public $attributes =[
    'tipo' => 0 , 'subprocesos' => 0, 'seguimiento' => 0, 'meta' => 0.00
    ];

    protected $fillable = [
        'empresa_id', 'area_id', 'servicio', 'meta', 'tipo', 'tmaquina', 'toperador', 'subprocesos', 'seguimiento', 'parent_id'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function area()
    {
        return $this->belongsTo('App\Models\Produccion\Area');
    }

    public function childs(){
    return $this->hasMany('App\Models\Produccion\Proceso', 'parent_id');
    }
}