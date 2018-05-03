<?php


namespace App\Models\Rules;


class UserRules
{
    const FIRST_NAME = ['required', 'string', 'max:255', "regex:/^[a-z'\- ]*$/i"];
    const LAST_NAME = ['required', 'string', 'max:255', "regex:/^[a-z'\-]*$/i"];
}