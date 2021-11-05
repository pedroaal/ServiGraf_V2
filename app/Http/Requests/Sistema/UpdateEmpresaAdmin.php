<?php

namespace App\Http\Requests\Sistema;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmpresaAdmin extends FormRequest
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
      'id' => ['required', 'numeric'],
      'nombre' => ['required', 'string', 'max:250'],
      'tipo_empresa_id' => ['required', 'exists:tipo_empresa,id'],
      'status' => ['nullable', 'boolean'],
    ];
  }
}
