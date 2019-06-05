<?php

namespace App\Http\Controllers\API\Crew;

use App\Actions\Crew\FetchJobByPosition;
use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Response;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::all();

        return response()->json([
            'positions' => $positions,
        ]);
    }

    public function ignored_jobs()
    {
        $crew = auth()->user()->crew;
        $jobs = app(FetchJobByPosition::class)->execute($crew, 'ignored');

        return response()->json([
                'message'   => 'Successfully fetched crew\'s ignored jobs',
                'jobs'      => $jobs
            ], Response::HTTP_OK
        );
    }
}
