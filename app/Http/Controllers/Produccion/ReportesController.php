<?php

namespace App\Http\Controllers\Produccion;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Produccion\Area;
use App\Models\Produccion\Pedido;
use App\Models\Ventas\Cliente;
use App\Models\Produccion\Proceso;
use App\Models\Produccion\Pedido_proceso;

class ReportesController extends Controller
{
  use SoftDeletes;

  /**
   * Create a new controller instance.
  *
  * @return void
  */
  // public function __construct()
  // {
  //   $this->middleware('auth');
  // }

  /**
   * @return View reporte de pedidos
   */
  public function showPedidos(){
    $clientes = Cliente::where('empresa_id', Auth::user()->empresa_id)->orderBy('cliente_empresa_id')->get();
    $areas = Area::where('empresa_id', Auth::user()->empresa_id)->orderBy('orden')->get();
    return view('Produccion.reportePedidos', compact('areas', 'clientes'));
  }

  public static function ajaxPedidos(Request $request){
    $pedidos = Pedido::where('empresa_id', Auth::user()->empresa_id)->select('cliente_id', 'numero', 'id', 'detalle', 'total_pedido', 'abono', 'saldo', 'estado')->whereBetween('fecha_entrada', [$request->fechaini, $request->fechafin]);
    if($request->cliente != 'none'){
      $pedidos->where('cliente_id', $request->cliente);
    }
    elseif($request->cobro != 'none'){
      $pedidos->where('estado', $request->cobro);
    }
    $pedidos = $pedidos->get();
    foreach($pedidos as $pedido){
      $pedido->cliente_nom = $pedido->cliente->full_name;
      $pedido->areas = Pedido::reporteAreas($pedido->id);
    }
    return response()->json($pedidos, 200);
  }

  /**
   * @return View reporte de pedidos
   */
  public function showPagos(){
    $clientes = Cliente::where('empresa_id', Auth::user()->empresa_id)->orderBy('cliente_empresa_id')->get();
    return view('Produccion.reportePagos', compact('clientes'));
  }

  public static function ajaxPagos(Request $request){
    $pedidos = Pedido::where('empresa_id', Auth::user()->empresa_id)->select('cliente_id', 'numero', 'id', 'fecha_entrada', 'fecha_cobro', 'detalle', 'usuario_cob_id', 'total_pedido', 'abono', 'saldo', 'estado')
      ->Where(function($query) use ($request) {
        $query->orWhere(function($query) use ($request) {
            $query->whereBetween('fecha_entrada', [$request->fechaini, $request->fechafin])
                  ->where('abono', '>', 0);
        })
        ->orWhere(function($query) use ($request) {
            $query->whereBetween('fecha_cobro', [$request->fechaini, $request->fechafin])
                  ->where('estado', 2);
        });
      });
    if($request->cliente != 'none'){
      $pedidos->where('cliente_id', $request->cliente);
    }
    $pedidos = $pedidos->get();
    foreach($pedidos as $pedido){
      $pedido->cliente_nom = $pedido->cliente->full_name;
      $pedido->usuario_cobro = $pedido->user_cob->nomina->nombre ?? 'N/A';
    }
    return response()->json($pedidos, 200);
  }

  /**
   * @return View reporte de maquinas
   */
  public function showMaquinas(){
    $procesos = Proceso::where('empresa_id', Auth::user()->empresa_id)->select('proceso', 'id')->where('seguimiento', 1)->orderBy('proceso')->get();
    return view('Produccion.reporteMaquinas', compact('procesos'));
  }

  public static function ajaxMaquinas(Request $request){
    $pedidos = Pedido::where('empresa_id', Auth::user()->empresa_id)->select('cliente_id', 'numero', 'id', 'detalle', 'total_pedido', 'estado')->whereBetween('fecha_entrada', [$request->fechaini, $request->fechafin]);
    if($request->cobro != 'none'){
      $pedidos->where('estado', $request->cobro);
    }
    $pedidos = $pedidos->get();
    foreach($pedidos as $pedido){
      $pedido->cliente_nom = $pedido->cliente->full_name;
      $pedido->procesos_id = Self::getSumProcesos($pedido->id);
    }
    return response()->json($pedidos, 200);
  }

  public static function getSumProcesos($id){
    return Pedido_proceso::where('pedido_id', $id)->select('proceso_id', DB::raw('sum(total) as totalProceso'))->groupBy('proceso_id')->get()->toArray();
  }
}