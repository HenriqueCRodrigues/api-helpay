<?php

namespace App\Http\Requests;

use App\Rules\CreditCardRule;
use App\Rules\QuantityPurchasedRule;
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
        $card = $this->request->get('card');
        $card = isset($card[0]) ? $card[0] : null;

        $flag = isset($card['flag']) ? $card['flag'] : null;

        return [
            'product_id' => 'required|exists:products,id', 
            'quantity_purchased' => [
                'required',
                new QuantityPurchasedRule($this->request->get('product_id'))
            ],
            'card' => 'required|array', 
            'card.*.owner' => 'required', 
            'card.*.card_number' => [
                'required',
                'integer',
                new CreditCardRule($flag)
            ], 
            'card.*.date_expiration' => 'required|date_format:m/Y', 
            'card.*.flag' => 'required', 
            'card.*.cvv' => 'required'
        ];
    }
}