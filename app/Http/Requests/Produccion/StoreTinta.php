<?php

namespace App\Http\Requests\Produccion;

use Illuminate\Foundation\Http\FormRequest;

class StoreTinta extends FormRequest
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
            'color' => ['required', 'string', 'max:140']
        ];
    }
}
