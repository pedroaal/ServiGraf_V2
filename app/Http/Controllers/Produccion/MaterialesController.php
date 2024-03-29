<?php

namespace App\Http\Controllers\Produccion;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

use App\Models\Produccion\Tinta;
use App\Models\Produccion\Material;
use App\Models\Produccion\Categoria;

use App\Http\Requests\Produccion\StoreMaterial;
use App\Http\Requests\Produccion\UpdateMaterial;

class MaterialesController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
  }

  /**
   * Show pedidos dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function show()
  {
    $user = Auth::user();
    $materiales = Material::where('empresa_id', $user->empresa_id)->with('categoria')->get();
    $tintas = Tinta::where('empresa_id', $user->empresa_id)->get();
    $categorias = Categoria::where('empresa_id', $user->empresa_id)->get();
    return view('Produccion/materiales', compact('materiales', 'tintas', 'categorias'));
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $material = new Material;
    $categorias = Categoria::where('empresa_id', Auth::user()->empresa_id)->get();
    $data = [
      'text' => 'Nuevo Material',
      'path' => route('material.create'),
      'method' => 'POST',
      'action' => 'Crear',
      'mod' => 0,
    ];
    return view('Produccion.material', compact('material', 'categorias'))->with($data);
  }

  // crear nuevo
  public function store(StoreMaterial $request)
  {
    $validator = $request->validated();
    $validator['empresa_id'] = Auth::user()->empresa_id;
    $validator['color'] = $validator['color'] ?? 0;
    $validator['uv'] = $validator['uv'] ?? 0;
    $validator['plastificado'] = $validator['plastificado'] ?? 0;

    DB::beginTransaction();
    try {
      if ($material = Material::create($validator)) {
        DB::commit();
        Alert::success('Acción completada', 'Material creada con éxito');
        return redirect()->route('material.edit', $material->id);
      }
    } catch (Exception $error) {
      DB::rollBack();
      Log::error($error);
      Alert::success('Acción completada', 'Material no creada');
      return redirect()->back()->withInput();
    }
  }

  //ver modificar
  public function edit(Material $material)
  {
    $categorias = Categoria::where('empresa_id', Auth::user()->empresa_id)->get();
    $data = [
      'text' => 'Modificar Material',
      'path' => route('material.update', $material->id),
      'method' => 'PUT',
      'action' => 'Modificar',
      'mod' => 1,
    ];
    return view('Produccion.material', compact('material', 'categorias'))->with($data);
  }

  // modificar material
  public function update(UpdateMaterial $request, Material $material)
  {
    $validator = $request->validated();
    $validator['color'] = $validator['color'] ?? 0;
    $validator['uv'] = $validator['uv'] ?? 0;
    $validator['plastificado'] = $validator['plastificado'] ?? 0;

    DB::beginTransaction();
    try {
      if ($material->update($validator)) {
        DB::commit();
        Alert::success('Acción completada', 'Material modificado con éxito');
        return redirect()->route('material.edit', $material->id);
      }
    } catch (Exception $error) {
      DB::rollBack();
      Log::error($error);
      Alert::error('Oops!', 'Material no modificado');
      return redirect()->back()->withInput();
    }
  }

  // eliminar material
  public function delete(Material $material)
  {
    DB::beginTransaction();
    try {
      if ($material->delete()) {
        DB::commit();
        Alert::success('Acción completada', 'Material eliminado con éxito');
        return redirect()->route('materiales');
      }
    } catch (Exception $error) {
      DB::rollBack();
      Log::error($error);
      Alert::error('Oops!', 'Material no eliminado');
      return redirect()->back();
    }
  }
}
