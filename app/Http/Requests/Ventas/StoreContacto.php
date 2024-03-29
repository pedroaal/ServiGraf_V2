<?php

namespace App\Http\Requests\Ventas;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CI;

class StoreContacto extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'empresa' => ['nullable', 'string'], //nombre de la empresa
      'ruc' => ['nullable', 'required_if:isCliente,true', 'string', new CI], //ruc de la empresa

      'actividad' => ['nullable', 'string'],
      'cargo' => ['nullable', 'string'],
      'titulo' => ['nullable', 'string'],
      'nombre' => ['required', 'string'],
      'apellido' => ['required', 'string'],
      'direccion' => ['nullable', 'required_if:isCliente,true', 'string'],
      'sector' => ['nullable', 'string'],
      'extencion' => ['nullable', 'numeric', 'max:9999'],
      'telefono' => ['nullable', 'numeric', 'required_if:celular,null'],
      'celular' => ['nullable', 'numeric', 'required_if:telefono,null'],
      'email' => ['nullable', 'email'],
      'web' => ['nullable', 'url'],
      'isCliente' => ['nullable', 'boolean'],
      'tipo_contribuyente' => ['required', 'numeric'],
      'seguimiento' => ['nullable', 'boolean'],
    ];
  }
}
