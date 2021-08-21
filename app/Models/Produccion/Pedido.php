<?php

namespace App\Models\Produccion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Produccion\Pedido_proceso;
use App\Models\Produccion\Proceso;

class Pedido extends Model
{
    public static $own = false;
    protected $table = 'pedidos';

    public $attributes =[
        'total_material' => 0.00
    ];

    protected $fillable = [
        'empresa_id', 'numero', 'usuario_id', 'usuario_mod_id', 'usuario_cob_id', 'cliente_id', 'fecha_entrada', 'fecha_salida', 'prioridad', 'estado', 'cotizado', 'fecha_cobro', 'detalle', 'papel', 'cantidad', 'corte_alto', 'corte_ancho', 'numerado_inicio', 'numerado_fin', 'total_material', 'total_pedido', 'abono', 'saldo', 'notas'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $casts = [
    ];

    /*
    * @return Orden_produccion con Procesos incompletos
    */

    public function user()
    {
        return $this->belongsTo('App\Models\Usuarios\Usuario', 'usuario_id', 'cedula');
    }

    public function user_mod()
    {
        return $this->belongsTo('App\Models\Usuarios\Usuario', 'usuario_mod_id', 'cedula');
    }

    public function user_cob()
    {
        return $this->belongsTo('App\Models\Usuarios\Usuario', 'usuario_cob_id', 'cedula');
    }

    public function cliente()
    {
        return $this->belongsTo('App\Models\Ventas\Cliente', 'cliente_id');
    }

    public function material()
    {
        return $this->hasMany('App\Models\Produccion\Solicitud_material');
    }

    public function procesos()
    {
        return $this->hasMany('App\Models\Produccion\Pedido_proceso');
    }

    public function tintas()
    {
        return $this->hasMany('App\Models\Produccion\Pedido_tintas');
    }

    public function abonos()
    {
        return $this->hasMany('App\Models\Produccion\Abono');
    }

    /**
     * @return App\Model\Produccion\Pedido que no esten terminados
     */
    public static function incompletas($fecha = null)
    {
      $incompletos = Pedido_proceso::where([['empresa_id', '=', auth()->user()->empresa_id], ['status', '=', '0']])
        ->groupBy('pedido_id')
        ->select('pedido_id')
        ->where(function($query) use ($fecha) {
          if(self::$own){
            $query->whereIn('proceso_id', Auth::user()->procesos->map(function($c){return $c->id;})->toArray());
          }
        })->get();
      $incompletos = $incompletos->map(function($incompletos){return $incompletos->pedido_id;});

      return Pedido::whereIn('id', $incompletos)->where('estado',  '!=', '3')->select('id', 'numero', 'cliente_id', 'detalle', 'cantidad')->where(function($query) use ($fecha) {
          if($fecha){
            $query->whereBetween('fecha_entrada', [date('Y-m-01', strtotime($fecha)), date('Y-m-t', strtotime($fecha))]);
          }
        })->get();
    }

    /*
    * @return lista con todos los procesos sin terminar
    */
    public static function serviciosIncompletos($pedido_id)
    {
        $OS = Pedido_proceso::where('pedido_id', strval($pedido_id))->get();
        $list = [];
        foreach ($OS as $proceso) {
            $serv = Proceso::where('id', $proceso->proceso_id)->value('proceso');
            if($proceso->subproceso_id != null){
                $serv = $serv.'-';
                // $serv = $serv.Sub_proceso::where('id', $proceso->subproceso_id)->value('subservicio');
            }
            $list[] = $serv;
        }
        return $list;
    }

    /**
     * @return lista con todos los procesos sin terminar
     */
    public static function todos()
    {
        $incompletas = Pedido::incompletas();
        $list = [];
        foreach ($incompletas as $pedido){
            $temp = [];
            $cli = $pedido->cliente;
            $temp['numero'] = $pedido->numero;
            $temp['detalle'] = $pedido->detalle;
            $temp['cantidad'] = $pedido->cantidad;
            $temp['procesos'] = $pedido->serviciosIncompletos($pedido->id);
            $temp['cliente'] = $cli->empresa->nombre.' / '.$cli->contacto->nombre.' '.$cli->contacto->apellido;
            $list[] = $temp;
        }
        return $list;
    }

    public static function reporteAreas($id){
        return Pedido_proceso::where('pedido_id', $id)->join('procesos', 'pedido_procesos.proceso_id' ,'=', 'procesos.id')->select('area_id', DB::raw('sum(total) as totalArea'))->groupBy('area_id')->get()->toArray();
    }

    /**
     * @return id de las tintas del retiro
     */
    public function tintasTiro($query){
        // return $query->tintas->reject(function($tinta){return $tinta->lado == 0;})->map(function($tintas){return $tintas->tinta_id;})->toArray()
        return $query->tintas->toArray();
    }

    // public function material()
    // {
    //     return $this->belongsTo('App\Models\Ventas\Cliente');
    // }

    // public function abonos()
    // {
    //     return $this->belongsTo('App\Models\Ventas\Cliente');
    // }
}
