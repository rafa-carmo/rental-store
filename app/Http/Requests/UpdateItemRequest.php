<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'item_type_id' => ['required', 'exists:item_types,id'],
            'status' => ['required', 'in:disponivel,alugado,indisponivel'],
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'name.max' => 'O nome não pode ter mais de 255 caracteres.',
            'image.image' => 'O arquivo deve ser uma imagem.',
            'image.max' => 'A imagem não pode ter mais de 2MB.',
            'item_type_id.required' => 'O tipo de item é obrigatório.',
            'item_type_id.exists' => 'O tipo de item selecionado não existe.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'O status deve ser disponível, alugado ou indisponível.',
        ];
    }
}
