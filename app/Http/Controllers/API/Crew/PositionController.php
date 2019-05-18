<?php

namespace App\Http\Controllers\API\Crew;

use App\Http\Controllers\Controller;
use App\Models\Position;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::all();

        return response()->json([
            'positions' => $positions,
        ]);
    }
}
