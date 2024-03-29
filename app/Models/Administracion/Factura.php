<?php

namespace App\Models\Administracion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Ventas\Cliente;
use App\Models\Produccion\Pedido;
use App\Models\Administracion\FactProd;
use App\Models\Sistema\FactEmpr;
use App\Models\Usuarios\Usuario;

class Factura extends Model
{
  use SoftDeletes;


  protected $table = 'facturas';

  protected $fillable = [
    'empresa_id', 'usuario_id', 'numero', 'fact_emp_id', 'cliente_id', 'emision', 'vencimiento', 'tipo', 'estado', 'tipo_pago', 'subtotal', 'descuento_p', 'descuento', 'iva', 'iva_0', 'total', 'ret_iva_p', 'ret_iva', 'ret_fuente_p', 'ret_fuente', 'total_pagar', 'notas'
  ];

  public $attributes = [
    'tipo' => 1, 'estado' => 1,
  ];

  public function usuario()
  {
    return $this->belongsTo(Usuario::class, 'usuario_id', 'cedula');
  }

  public function empresa()
  {
    return $this->belongsTo(FactEmpr::class, 'fact_emp_id');
  }

  public function cliente()
  {
    return $this->belongsTo(Cliente::class)->withTrashed();
  }

  public function productos()
  {
    return $this->hasMany(FactProd::class);
  }

  public function pedidos_id()
  {
    return $this->hasMany(FacturaPedido::class);
  }

  public function pedidos()
  {
    return $this->belongsToMany(Pedido::class, 'factura_ots');
  }
}
