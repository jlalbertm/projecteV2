<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CicloFormativoRequest extends FormRequest {
    public function authorize() { return true; } // Canvia a true

    public function rules() {
        return [
            'nombre' => 'required|string|max:150',
            'familia_profesional' => 'required|string|max:100',
            'grado' => 'required|string|max:50',
            'modalidad' => 'required|string|max:80',
            'decreto_referencia' => 'required|string|max:250',
            'activo' => 'required|boolean',
        ];
    }
}