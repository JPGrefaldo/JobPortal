<?php

namespace App\Rules;

use App\Models\User;
use App\Models\EndorsementEndorser;
use Illuminate\Contracts\Validation\Rule;

class CreateCrewEndorsement implements Rule
{
    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->message = '';
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
        if (isset($crewCheck)) {
            $endorserCheck  = EndorsementEndorser::where('user_id', $crewCheck->id)->first();
        }
        $ownEndorsement = $value == auth()->user()->email;

        if (isset($crewCheck) && !isset($endorserCheck) && !$ownEndorsement) {
            return true;
        } elseif (isset($crewCheck) && $ownEndorsement) {
            $this->message = "You cannot send endosement request to your own email";

            return false;
        } elseif (isset($crewCheck) && isset($endorserCheck)) {
            $this->message = "You already sent endorsement request to that email";

            return false;
        } else {
            $this->message = "Email doesn't exist";

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
        return $this->message;
    }
}
