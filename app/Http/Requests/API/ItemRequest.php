<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
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
             "contrato_id" => "required|integer|exists:contratos,id",
                "obra_id" => "required|integer|exists:obras,id",
                "item" => "required|string",
                "servico" => "required|string",
                "unidade" => "required|string",
                "quantidade" => "required|numeric",
                "preco" => "required|numeric",
                "total" => "required|numeric",
        ];
    }
}