<?php

namespace App\Rules;

use App\Models\Customers;
use Illuminate\Contracts\Validation\Rule;

class CustomerExist implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $customer = Customers::where('AccountNumber', request()->AccountNumber)
                                ->where('FirstName', request()->FirstName)
                                ->where('MiddleName', request()->MiddleName)
                                ->where('LastName', request()->LastName)
                                ->first();
        if(!$customer == null){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'No Account found.';
    }
}
