<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Http\Request;
use App\Actions\Messenger\SearchParticipants;

class ParticipantsController extends Controller
{
    public function search(Thread $thread, Request $request)
    {
        $keyword = $request->keyword;

        if (! isset($keyword)){
            return response()->json([
                'message' => 'Keyword should not be empty'
            ]);
        }

        if (preg_match("/\d+/", $keyword)) {
            return response()->json([
                'message' => 'Keyword should only be a string'
            ]);
        }
    
        $result = app(SearchParticipants::class)->execute($thread, $keyword);

        if (count($result) == 0){
            return response()->json([
                'message' => 'No results can be found'
            ]);
        }

        return $result;
    }
}
