<?php

namespace App\Http\Controllers\API\Crew;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Position;

class PositionsController extends Controller
{
    public function index()
    {
        $positions = Position::all();

        return response()->json([
            'positions' => $positions
        ]);
    }
}
