<?php

namespace App\Http\Requests\Administracion;

use Illuminate\Foundation\Http\FormRequest;

class StoreDotacion extends FormRequest
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
      'dotacion' => ['required', 'string'],
      'status' => ['required', 'boolean']
    ];
  }
}
