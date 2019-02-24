<?php

namespace App\Http\Controllers;

use App\Actions\Messenger\CreateMessage;
use App\Http\Resources\MessageResource;
use App\Models\Role;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Http\Request;

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

        $messages = $thread->messages()->where('flagged_at', null)->get();

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
        // return $request->all();
        $thread = Thread::findOrFail($request->thread);
        $sender = $request->sender;
        $body = $request->message;

        $participant = $thread->users()
                              ->where('user_id', $sender)
                              ->first();

        // Optional
        if(! isset($participant)) {
            return response()->json([
                'error' => 'You are not included to this thread'
            ]);
        }

        if($participant->hasRole(Role::ADMIN)) {
            return response()->json([
                'error' => 'Admin is not allowed to participate on this thread'
            ]);
        }

        $message = app(CreateMessage::class)->execute($thread->id, $sender, $body);
        return response()->json(compact('message'));
    }
}
