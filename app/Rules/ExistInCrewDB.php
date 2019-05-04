<?php

namespace App\Rules;

use App\Models\CrewPosition;
use App\Models\Position;
use App\Actions\Crew\GetCrewPositionByPosition;
use Illuminate\Contracts\Validation\ImplicitRule;

class ExistInCrewDB implements ImplicitRule
{
    private $crewPosition;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->crewPosition = $this->getCrewPosition(request()->position_id);
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
        if (empty($value)) {
            return (bool) optional($this->crewPosition)->$attribute;
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
        return ':attribute is required';
    }


    private function getCrewPosition($position)
    {
        $position = Position::find($position);
   
        try {
            return app(GetCrewPositionByPosition::class)->execute(auth()->user(), $position);
        } catch (\Exception $ex) {
           return false;
        }
    }
}
