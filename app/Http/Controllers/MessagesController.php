<?php

namespace App\Http\Controllers;

use App\Actions\Messenger\CreateMessage;
use App\Http\Resources\MessageResource;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Http\Request;
use App\Models\Role;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Thread $thread)
    {
        $user = auth()->user();

        if (! $thread->hasParticipant($user->id)) {
            return abort(403);
        }

        $messages = $thread->messages()->with('user')->where('flagged_at', null)->get();

        return MessageResource::collection($messages);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sender = auth()->user();
        
        if ($sender->hasRole(Role::CREW)){
            return response()->json([
                'message' => 'You are not allowed to message the producer'
            ]);
        }

        $thread = Thread::findOrFail($request->thread);
        $body = $request->message;
        
        $message = app(CreateMessage::class)->execute($thread->id, $sender->id, $body);
        
        return response()->json(compact('message'));
    }
}
