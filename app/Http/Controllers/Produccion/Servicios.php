<?php
namespace App\Http\Controllers\Produccion;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Models\Produccion\Proceso;
use App\Models\Produccion\Area;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Requests\Produccion\StoreProceso;
use App\Http\Requests\Produccion\UpdateProceso;

class Procesos extends Controller
{
  use AuthenticatesUsers;
  /**
  * Create a new controller instance.
  *
  * @return void
  */
  public function __construct()
  {
  }

  /**
  * Show the application dashboard.
  *
  * @return \Illuminate\Http\Response
  */
  public function create(){
    $proceso = new Proceso;
    $areas = Area::where('empresa_id', Auth::user()->empresa_id)->get();
    $data = [
      'text' => 'Nuevo Proceso',
      'path' => route('proceso.store'),
      'method' => 'POST',
      'action' => 'Crear',
    ];
    return view('Produccion.proceso', compact('proceso', 'areas'))->with($data);
  }

  // // crear nuevo
  public function store(StoreProceso $request){
    $validator = $request->validated();
    // dd($validator);
    $validator['empresa_id'] = Auth::user()->empresa_id;
    $proceso = Proceso::create($validator);

    $data = [
      'type'=>'success',
      'title'=>'Acción completada',
      'message'=>'El  se ha creado con éxito'
    ];
    return redirect()->route('proceso.edit', $proceso->id)->with(['actionStatus' => json_encode($data)]);
  }

  // //ver modificar
  public function edit(Proceso $proceso){
    $areas = Area::where('empresa_id', Auth::user()->empresa_id)->get();
    $data = [
      'text'=>'Modificar Proceso',
      'path'=> route('proceso.update', $proceso->id),
      'method' => 'PUT',
      'action'=>'Modificar',
    ];
    return view('Produccion.proceso', compact('proceso', 'areas'))->with($data);
  }

  // //modificar perfil
  public function update(UpdateProceso $request, Proceso $proceso){
    $validator = $request->validated();
    $validator['subprocesos'] = $validator['subprocesos'] ?? 0;
    $validator['seguimiento'] = $validator['seguimiento'] ?? 0;
    // dd($validator);

    $proceso->update($validator);

    $data = [
      'type'=>'success',
      'title'=>'Acción completada',
      'message'=>'El  se ha modificado con éxito'
    ];
    return redirect()->route('proceso.edit', $proceso->id)->with(['actionStatus' => json_encode($data)]);
  }
}
