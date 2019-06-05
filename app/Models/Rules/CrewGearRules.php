<?php

namespace App\Models\Rules;

class CrewGearRules
{
    public static function gear($position)
    {
        if ($position['has_gear']) {
            return 'required|string|max:50|min:8';
        } else {
            return 'nullable|string|max:50|min:8';
        }
    }

    public static function gear_photos($gear_photos)
    {
        if ($gear_photos != "null") {
            return 'nullable|image|mimes:jpeg,png';
        } else {
            return 'nullable';
        }
    }
}