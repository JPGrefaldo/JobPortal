<?php

namespace App\Models\Rules;

class CrewPositionRules
{
    public static function position_description($position)
    {
        if ($position['has_union']) {
            return 'required|string|max:50|min:8';
        } else {
            return 'nullable|string|max:50|min:8';
        }
    }
}