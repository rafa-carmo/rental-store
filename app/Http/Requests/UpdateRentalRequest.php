<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRentalRequest extends FormRequest
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
            'customer_id' => ['required', 'integer', 'exists:customers,id'],
            'item_id' => ['required', 'integer', 'exists:items,id'],
            'value' => ['required', 'numeric', 'min:0'],
            'pickup_date' => ['required', 'date'],
            'return_date' => ['required', 'date', 'after_or_equal:pickup_date'],
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
            'customer_id.required' => 'O cliente é obrigatório.',
            'customer_id.integer' => 'O cliente deve ser um número inteiro.',
            'customer_id.exists' => 'O cliente selecionado não existe.',
            'item_id.required' => 'O item é obrigatório.',
            'item_id.integer' => 'O item deve ser um número inteiro.',
            'item_id.exists' => 'O item selecionado não existe.',
            'value.required' => 'O valor é obrigatório.',
            'value.numeric' => 'O valor deve ser um número.',
            'value.min' => 'O valor deve ser maior ou igual a zero.',
            'pickup_date.required' => 'A data de retirada é obrigatória.',
            'pickup_date.date' => 'A data de retirada deve ser uma data válida.',
            'return_date.required' => 'A data de entrega é obrigatória.',
            'return_date.date' => 'A data de entrega deve ser uma data válida.',
            'return_date.after_or_equal' => 'A data de entrega deve ser igual ou posterior à data de retirada.',
        ];
    }
}
