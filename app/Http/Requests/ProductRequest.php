<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required', 
            'amount' => 'required|numeric', 
            'qty_stock' => 'required|integer',
        ];
    }

    public function messages() {
        return [
            'name.required' => 'O nome é obrigatório.', 
            'amount.required' => 'O preço é obrigatório.', 
            'amount.numeric' => 'O preço só aceita valores númericos.', 
            'qty_stock.required' => 'O estoque é obrigatório.',
            'qty_stock.integer' => 'O estoque só aceita valores inteiro.',
        ];
    }
}
