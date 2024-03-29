<?php

namespace App\Http\Controllers\Produccion;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\Produccion\Pedido;
use App\Models\Produccion\Pedido_tintas;
use App\Models\Produccion\Pedido_proceso;
use App\Models\Produccion\Solicitud_material;

class ImprentaController extends Controller
{
  public function manageTintas($request, Pedido $model)
  {
    $relation = $model->tintas_id();
    if ($relation->count()) {
      $relation->delete();
    }

    if (!isset($request['tinta_tiro']) and !isset($request['tinta_retiro'])) {
      return 0;
    }

    foreach ($request['tinta_tiro'] ?? [] as $ttiro) {
      $tinta = new Pedido_tintas;
      $tinta->tinta_id = $ttiro;
      $tinta->pedido_id = $model->id;
      $tinta->lado = 1;
      $tinta->save();
    }

    foreach ($request['tinta_retiro'] ?? [] as $tretiro) {
      $tinta = new Pedido_tintas;
      $tinta->tinta_id = $tretiro;
      $tinta->pedido_id = $model->id;
      $tinta->lado = 0;
      $tinta->save();
    }
  }

  public function manageSolicitudMaterial($request, Pedido $model)
  {
    $relation = $model->material_id();
    if ($relation->count()) {
      $relation->delete();
    }

    if (!isset($request['material_id'])) {
      return 0;
    }

    $cnt = count($request['material_id'] ?? []);
    for ($i = 0; $i < $cnt; $i++) {
      $material = new Solicitud_material;
      $material->empresa_id = Auth::user()->empresa_id;
      $material->pedido_id = $model->id;
      $material->material_id = $request['material_id'][$i];
      $material->cantidad = $request['material_cantidad'][$i];
      $material->corte_alto = $request['material_corte_alt'][$i];
      $material->corte_ancho = $request['material_corte_anc'][$i];
      $material->tamanos = $request['material_tamanios'][$i];
      $material->proveedor_id = $request['material_proveedor'][$i];
      $material->factura = $request['material_factura'][$i];
      $material->total = $request['material_total'][$i];
      $material->save();
    }
  }

  public function manageProcesos($request, Pedido $model)
  {
    $relation = $model->procesos_id();
    if ($relation->count()) {
      $relation->delete();
    }

    if (!isset($request['proceso_id'])) {
      return 0;
    }

    $cnt = count($request['proceso_id'] ?? []);
    for ($i = 0; $i < $cnt; $i++) {
      $proceso = new Pedido_proceso;
      $proceso->empresa_id = Auth::user()->empresa_id;
      $proceso->pedido_id = $model->id;
      $proceso->proceso_id = $request['proceso_id'][$i];
      $proceso->tiro = $request['proceso_tiro'][$i];
      $proceso->retiro = $request['proceso_retiro'][$i];
      $proceso->millares = $request['proceso_millar'][$i];
      $proceso->valor_unitario = $request['proceso_valor'][$i];
      $proceso->total = $request['proceso_total'][$i];
      $proceso->status = $request['proceso_terminado'][$i] ?? 0;
      $proceso->save();
    }
  }

  public function duplicateTintas(Pedido $model, Pedido $new_model)
  {
    $relation = $model->tintas_id;
    if (!$relation->count()) {
      return;
    }
    foreach ($relation as $item) {
      $new = $item->replicate();
      $new->pedido_id = $new_model->id;
      $new->save();
    }
    return;
  }

  public function duplicateSolicitudMaterial(Pedido $model, Pedido $new_model)
  {
    $relation = $model->material_id;
    if (!$relation->count()) {
      return;
    }
    foreach ($relation as $item) {
      $new = $item->replicate();
      $new->pedido_id = $new_model->id;
      $new->save();
    }
    return;
  }

  public function duplicateProcesos(Pedido $model, Pedido $new_model)
  {
    $relation = $model->procesos_id;
    if (!$relation->count()) {
      return;
    }
    foreach ($relation as $item) {
      $new = $item->replicate();
      $new->pedido_id = $new_model->id;
      $new->save();
    }
    return;
  }
}
