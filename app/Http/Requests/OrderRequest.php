<?php

namespace App\Http\Requests;

use App\Rules\CreditCardRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderRequest extends FormRequest
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
            'product_id' => 'required|exists:products,id', 
            'quantity_purchased' => [
                'required',
                Rule:: exists('products', 'qty_stock')->where(function ($query) {
                    $query->where('products.id', $this->request->get('product_id'));
                    $query->where('products.qty_stock', '<=', $this->request->get('quantity_purchased'));
                })
            ],
            'card_number' => [
                'required',
                'integer',
                new CreditCardRule($this->request->get('flag'))
            ], 
            'date_expiration' => 'required|date_format:m/Y', 
            'flag' => 'required', 
            'cvv' => 'required'
        ];
    }
}