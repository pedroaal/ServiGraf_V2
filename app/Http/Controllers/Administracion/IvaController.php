<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administracion\Iva as RequestIva;
use App\Models\Administracion\Iva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IvaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestIva $request)
    {
      $validated = $request->validated();
      $validated['empresa_id'] = Auth::user()->empresa_id;
      $validated['status'] = $validated['status'] ?? 0;

      Iva::create($validated);

      $data = [
        'type'=>'success',
        'title'=>'Acción completada',
        'message'=>'El iva se ha creado con éxito'
      ];
      return redirect()->back()->with($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RequestIva $request, Iva $iva)
    {
      $validated = $request->validated();
      $validated['status'] = $validated['status'] ?? 0;

      $iva->update($validated);

      $data = [
        'type'=>'success',
        'title'=>'Acción completada',
        'message'=>'El iva se ha modificado con éxito'
      ];
      return redirect()->back()->with($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}