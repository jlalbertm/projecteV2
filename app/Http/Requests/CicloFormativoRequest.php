<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CicloFormativoRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a realizar esta petición.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Reglas de validación aplicadas a la petición.
     */
    public function rules()
    {
        return [
            'nombre' => 'required|string|max:150',
            'familia_profesional' => 'required|string|max:100',
            'grado' => 'required|string|max:50',
            'modalidad' => 'required|string|max:80',
            'decreto_referencia' => 'required|string|max:250',
            'activo' => 'nullable',
        ];
    }
}
