<?php

namespace App\Http\Requests\Administracion;

use Illuminate\Foundation\Http\FormRequest;

class StoreFactura extends FormRequest
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
          'empresa_id' => [],
          'usuario_id' => [],
          'numero' => [],
          'fact_emp_id' => [],
          'cliente_id' => [],
          'emision' => [],
          'vencimiento' => [],
          'tipo' => [],
          'estado' => [],
          'tipo_pago' => [],
          'subtotal' => [],
          'descuento_%' => [],
          'descuento' => [],
          'iva' => [],
          'iva_0' => [],
          'total' => [],
          'ret_iva_%' => [],
          'ret_iva' => [],
          'ret_fuente_%' => [],
          'ret_fuente' => [],
          'total_pagar' => [],
          'notas' => []
        ];
    }
}