<?php

namespace App\Http\Controllers\Sistema;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Sistema\DatosEmpresa;
use App\Models\Sistema\Fact_empr;
use App\Http\Requests\Sistema\StoreEmpresa;
use App\Http\Requests\Sistema\UpdateEmpresa;

class Empresa extends Controller
{
    public function show(){
        $empresa = Auth::user()->empresa->datos ?? new DatosEmpresa;
        return view('Sistema.empresa', compact('empresa'));
    }

    public function store(StoreEmpresa $request){
        $validated = $request->validated();
        $validated['empresa_id'] = Auth::user()->empresa_id;
        $validated['usuario_id_mod'] = Auth::id();
        $empresa = DatosEmpresa::create($validated);
        $data = [
            'type'=>'success',
            'title'=>'Acción completada',
            'message'=>'Los datos se ha creado con éxito'
        ];
        return redirect()->route('empresa')->with(['actionStatus' => json_encode($data)]);
    }

    public function update(UpdateEmpresa $request, DatosEmpresa $empresa){
        $validated = $request->validated();
        $empresa->update($validated);
        $data = [
            'type'=>'success',
            'title'=>'Acción completada',
            'message'=>'Los datos se ha modificado con éxito'
        ];
        return redirect()->back()->with(['actionStatus' => json_encode($data)]);
    }
}
