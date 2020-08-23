<?php

namespace App\Rules;

use App\Repositories\OrderRepository;
use App\Services\CreditCardService;
use Illuminate\Contracts\Validation\Rule;

class CreditCardRule implements Rule
{
    protected $flag;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($flag)
    {
        $this->flag = $flag;
        $this->creditCardService = new CreditCardService();
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
        if ($this->flag) {
            return $this->creditCardService->validateCC($value, $this->flag);
        }

        return false;
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
