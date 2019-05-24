<?php

namespace App\Rules;

use App\Models\User;
use App\Models\EndorsementEndorser;
use Illuminate\Contracts\Validation\Rule;

class CreateCrewEndorsement implements Rule
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
        $crewCheck      = User::with('crew')->where('email', $value)->first();
        $endorserCheck  = EndorsementEndorser::where('email', $value)->first();
        $ownEndorsement = $value == auth()->user()->email;

        // dd($ownEndorsement);

        if (isset($crewCheck) && !isset($endorserCheck) || isset($crewCheck) && !isset($ownEndorsement))
            return true;
        else
            return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "The email doesn't exist or You already sent endorsement request to that email";
    }
}
