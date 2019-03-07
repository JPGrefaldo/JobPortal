<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Http\Request;

class ParticipantsController extends Controller
{
    public function search(Request $request)
    {
        $keyword = $request->keyword;

        if (! isset($keyword)){
            return response()->json([
                'invalid' => 'Keyword should not be empty'
            ]);
        }

        if (preg_match("/\d+/", $keyword)) {
            return response()->json([
                'invalid' => 'Keyword should only be a string'
            ]);
        }

        $thread = Thread::findOrFail($request->thread);
        $user = auth()->user();
        
        return $thread->users()
                      ->where('user_id', '!=', $user->id)
                      ->where('first_name', 'like', '%'.ucfirst(strtolower($keyword)).'%')
                      ->orWhere('last_name', 'like', '%'.ucfirst(strtolower($keyword)).'%')
                      ->get();
    }
}
