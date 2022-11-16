<?php

namespace App\Rules;

use App\Models\Customers;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class CustomerAlreadyRegistered implements Rule
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
                                ->first();
        if($customer == null){
            return true;
        }else{
            $user = User::where('CustomerId', $customer->id)->first();
            if(!$user == null){
                return false;
            }else{
                return true;
            }
        }

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This account is already registered.';
    }
}
