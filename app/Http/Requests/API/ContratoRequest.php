<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class ContratoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'obra_id' => ['required',  'integer', 'exists:obras,id'],
            'obra_idnumero' => ['required',  'integer', 'exists:obras,id'],
            'tipo' => ['required', 'string', 'in:ADITIVO,NORMAL,REDUTIVO'],
            'inicio' => ['required', 'date'],
            'validade' => ['required', 'date'],
        ];
    }
}