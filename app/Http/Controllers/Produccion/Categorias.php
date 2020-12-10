<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\Produccion\StoreCategoria;
use App\Http\Requests\Produccion\UpdateCategoria;
use App\Models\Produccion\Categoria;

class Categorias extends Controller
{
    // crear nuevo
  public function store(StoreCategoria $request){
    $validator = $request->validated();
    $validator['empresa_id'] = Auth::user()->empresa_id;
    $categoria = Categoria::create($validator);

    $data = [
      'type'=>'success',
      'title'=>'Acción completada',
      'message'=>'El pedido se ha creado con éxito'
    ];
    return redirect()->back()->with(['actionStatus' => json_encode($data)]);
  }

  //modificar perfil
  public function update(UpdateCategoria $request, Categoria $categoria){
    $validator = $request->validated();
    $categoria->update($validator);

    $data = [
      'type'=>'success',
      'title'=>'Acción completada',
      'message'=>'El pedido se ha modificado con éxito'
    ];
    return redirect()->back()->with(['actionStatus' => json_encode($data)]);
  }
}
