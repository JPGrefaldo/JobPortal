<?php

namespace App\Http\Controllers\API;

use App\Actions\Messenger\SearchParticipants;
use App\Http\Controllers\Controller;
use App\Models\Thread;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function search(Thread $thread, Request $request)
    {
        $keyword = $request->keyword;

        if (! isset($keyword)) {
            return response()->json([
                'message' => 'Keyword should not be empty',
            ]);
        }

        if (preg_match("/\d+/", $keyword)) {
            return response()->json([
                'message' => 'Keyword should only be a string',
            ]);
        }

        $result = app(SearchParticipants::class)->execute($thread, $keyword);

        if (count($result) == 0) {
            return response()->json([
                'message' => 'No results can be found',
            ]);
        }

        return $result;
    }
}
