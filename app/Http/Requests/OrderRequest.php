<?php

namespace App\Http\Requests;

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
                Rule::exists('staff')->where(function ($query) {
                    $query->where('id', $this->request->get('product'));
                    $query->where('qty_stock', '<=', $this->request->get('quantity_purchased'));
                }),
            ],
            'card' => 'required', 
            'card_number' => 'required|integer', 
            'date_expiration' => 'required|date|date_format:mm/YYYY', 
            'flag' => 'required', 
            'cvv' => 'required'
        ];
    }
}