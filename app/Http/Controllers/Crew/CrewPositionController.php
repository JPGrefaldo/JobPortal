<?php

namespace App\Http\Controllers\Crew;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CrewPosition;
use App\Models\Position;

class CrewPositionController extends Controller
{
    public function applyFor(Position $position, $attributes){

        $this->positions()->attach($position, [
            'bio' => $attributes['bio'],
            'gear' => $attributes['gear'],
            'has_gear'=> $attributes['has_gear']
            ]);
        }
}
