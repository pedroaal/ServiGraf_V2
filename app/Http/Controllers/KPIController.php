<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Helpers\Functions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Produccion\Pedido;
use App\Models\Produccion\Proceso;
use App\Models\Administracion\Factura;
use App\Models\Produccion\Pedido_proceso;

class KPIController extends Controller
{
  // PRODUCCION
  public function kpi_facturado(Request $request)
  {
    $date = $request->get('fecha');
    $dateInit = date('Y-m-01', strtotime($date));
    $dateFin = date('Y-m-t', strtotime($date));

    $title = 'Facturado';
    $value = Factura::where('empresa_id', Auth::user()->empresa_id)->whereBetween('emision', [$dateInit, $dateFin])->sum('total');
    $icon = 'fa-file-invoice-dollar';
    $color = 'primary';

    // return response()->json($data, 200);
    return view('components.kpi', compact('title', 'value', 'icon', 'color'));
  }

  public function kpi_utilidad(Request $request)
  {
    $date = $request->get('fecha');
    $dateInit = date('Y-m-01', strtotime($date));
    $dateFin = date('Y-m-t', strtotime($date));

    $facturas = Factura::where('empresa_id', Auth::user()->empresa_id)->whereBetween('emision', [$dateInit, $dateFin]);
    $total_facturado = $facturas->sum('total');
    $pedidos = $facturas->with('pedidos')->get();

    $total_producido = $pedidos->map(function ($f) {
      return $f->pedidos->sum('total_pedido');
    })->sum();

    $total_cotizado = $pedidos->map(function ($f) {
      return $f->pedidos->sum('cotizado');
    })->sum();

    $value = strval($total_facturado - $total_producido) . ' / ' . strval($total_cotizado - $total_producido);

    $title = 'Utilidades Facturado / Cotizado';
    $value = $value;
    $icon = 'fa-file-invoice-dollar';
    $color = 'primary';

    // return response()->json($data, 200);
    return view('components.kpi', compact('title', 'value', 'icon', 'color'));
  }

  public function kpi_cobrar(Request $request)
  {
    $date = $request->get('fecha');
    $dateInit = date('Y-m-01', strtotime($date));
    $dateFin = date('Y-m-t', strtotime($date));

    $title = 'Por Cobrar';
    $value = Factura::where('empresa_id', Auth::user()->empresa_id)->whereBetween('emision', [$dateInit, $dateFin])->where('estado', 1)->sum('total');
    $icon = 'fa-file-invoice-dollar';
    $color = 'primary';

    // return response()->json($data, 200);
    return view('components.kpi', compact('title', 'value', 'icon', 'color'));
  }

  // public function kpi_flujo_efectivo(Request $request) {

  //     $title = 'Flujo de Efectivo';
  //     $value = '';
  //     $icon = 'fa-file-invoice-dollar';
  //     $color = '';

  //   return response()->json($data, 200);
  //   return view('components.kpi', compact('title', 'value', 'icon', 'color'));
  // }

  public function kpi_lob_facturacion(Request $request)
  {
    $user = Auth::user();
    $date = $request->get('fecha');
    $dateInit = date('Y-m-01', strtotime($date));
    $dateFin = date('Y-m-t', strtotime($date));

    $lastmonth = new Carbon($date);
    $lastmonth->subMonth()->endOfMonth();
    $twoyears = new Carbon($date);
    $twoyears->startOfMonth()->subYear(2);

    $prediccion = Factura::where('empresa_id', $user->empresa_id)->whereBetween('emision', [$twoyears, $lastmonth])->select(DB::raw('sum(total) as total'), DB::raw("DATE_PART('MONTH', emision) as months"))->groupBy('months')->get()->avg('total') ?? 0;
    $actual = Factura::where('empresa_id', $user->empresa_id)->whereBetween('emision', [$dateInit, $dateFin])->sum('total');
    $value = strval($actual) . ' / ' . strval($prediccion);

    $title = 'Utilidad Actual / Predicha';
    $value = $value;
    $icon = 'fa-file-invoice-dollar';
    $color = Functions::getColor($actual, $prediccion);

    // return response()->json($data, 200);
    return view('components.kpi', compact('title', 'value', 'icon', 'color'));
  }

  public function kpi_maquinas(Request $request)
  {
    $user = Auth::user();
    $date = $request->get('fecha');
    $dateInit = date('Y-m-01', strtotime($date));
    $dateFin = date('Y-m-t', strtotime($date));

    $value = Pedido_proceso::where('empresa_id', $user->empresa_id)
      ->whereRelation('proceso', 'seguimiento', 1)
      ->whereRelation('pedido', 'fecha_entrada', '>=', $dateInit)
      ->whereRelation('pedido', 'fecha_entrada', '<=', $dateFin)
      ->sum('total');

    $title = 'Máquinas';
    $value = $value;
    $icon = 'fa-cogs';
    $color = 'primary';

    // return response()->json($data, 200);
    return view('components.kpi', compact('title', 'value', 'icon', 'color'));
  }

  public function kpi_ots(Request $request)
  {
    $date = $request->get('fecha');
    $dateInit = date('Y-m-01', strtotime($date));
    $dateFin = date('Y-m-t', strtotime($date));

    $pedidos = Pedido::where('empresa_id', Auth::user()->empresa_id)->whereBetween('fecha_entrada', [$dateInit, $dateFin])->count();

    $incompletos = Pedido_proceso::where('empresa_id', Auth::user()->empresa_id)->where('status', '0')->select('pedido_id')->groupBy('pedido_id')->count();

    $value = strval($pedidos - $incompletos) . ' / ' . strval($incompletos);

    $title = 'Pedidos Terminados / Incompletos';
    $value = $value;
    $icon = 'fa-cogs';
    $color = 'primary';

    // return response()->json($data, 200);
    return view('components.kpi', compact('title', 'value', 'icon', 'color'));
  }

  public function kpi_lob_ots(Request $request)
  {
    $user = Auth::user();
    $date = $request->get('fecha');
    $dateInit = date('Y-m-01', strtotime($date));
    $dateFin = date('Y-m-t', strtotime($date));

    $lastmonth = new Carbon($date);
    $lastmonth->subMonth()->endOfMonth();
    $twoyears = new Carbon($date);
    $twoyears->startOfMonth()->subYear(2);

    $prediccion = Pedido::where('empresa_id', $user->empresa_id)->whereBetween('fecha_entrada', [$twoyears, $lastmonth])->select(DB::raw('sum(total_pedido) as total'), DB::raw("DATE_PART('MONTH', fecha_entrada) as months"))->groupBy('months')->get()->avg('total') ?? 0;

    $actual = Pedido::where('empresa_id', $user->empresa_id)->whereBetween('fecha_entrada', [$dateInit, $dateFin])->sum('total_pedido');

    $value = strval($actual) . ' / ' . strval(number_format($prediccion, 2, '.', ''));

    $title = 'Producción Actual / Predicha';
    $value = $value;
    $icon = 'fa-cogs';
    $color = Functions::getColor($actual, $prediccion);

    // return response()->json($data, 200);
    return view('components.kpi', compact('title', 'value', 'icon', 'color'));
  }

  public function kpi_cotizado(Request $request)
  {
    $user = Auth::user();
    $date = $request->get('fecha');
    $dateInit = date('Y-m-01', strtotime($date));
    $dateFin = date('Y-m-t', strtotime($date));

    $cotizado = Pedido::where('empresa_id', $user->empresa_id)
      ->whereBetween('fecha_entrada', [$dateInit, $dateFin])
      ->sum('cotizado');

    $title = 'Cotizado Total';
    $value = $cotizado;
    $icon = 'fa-file-invoice-dollar';
    $color = 'success';

    // return response()->json($data, 200);
    return view('components.kpi', compact('title', 'value', 'icon', 'color'));
  }

  // public function kpi_(Request $request) {

  //   $title = '';
  //   $value = '';
  //   $icon = '';
  //   $color = '';

  //   return response()->json($data, 200);
  //   return view('components.kpi', compact('title', 'value', 'icon', 'color'));
  // }
}
