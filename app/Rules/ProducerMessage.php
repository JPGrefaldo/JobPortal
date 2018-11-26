<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class ProducerMessage implements Rule
{
    protected $project;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($project)
    {
        $this->project = $project;
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
        $users = User::whereIn('hash_id', $value)->get(['id']);

        foreach ($users as $user) {
            if (! $this->project->contributors->contains($user->crew->id)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The selected recipients is invalid.';
    }
}
