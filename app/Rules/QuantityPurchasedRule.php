<?php

namespace App\Rules;

use App\Models\Product;
use Illuminate\Contracts\Validation\Rule;

class QuantityPurchasedRule implements Rule
{
    protected $product_id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($product_id)
    {
        $this->product_id = $product_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Product::where('id', $this->product_id)->where('qty_stock', '>=', $value)->first();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
