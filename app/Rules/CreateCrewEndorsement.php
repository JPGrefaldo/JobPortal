<?php

namespace App\Rules;

use App\Models\EndorsementEndorser;
use App\Models\User;
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
        $ownEndorsement = $value == auth()->user()->email;

        $user = User::where('email', $value)->first();

        if (isset($user)) {
            $existingEndorementRequest = EndorsementEndorser::where('request_owner', auth()->user()->id)->where('user_id', $user->id)->get();
        } else {
            $existingEndorementRequest = EndorsementEndorser::where('email', $value)->where('user_id', $user)->get();
        }
        
        if ($ownEndorsement) {
            $this->message = "You cannot send endosement request to your own email";

            return false;
        } if ($existingEndorementRequest->count() > 0) {
            $this->message = "You already sent endorsement request to that email";

            return false;
        } else {
            return true;
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
