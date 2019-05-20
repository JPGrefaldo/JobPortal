<?php

namespace App\Http\Controllers;

use App\Actions\Messenger\StoreMessage;
use App\Http\Resources\MessageResource;
use App\Models\Role;
use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MessageController extends Controller
{
    protected $userIsParticipant = false;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Thread $thread)
    {   
        $user = auth()->user();
        $messages = $thread->messages()->with('user')->where('flagged_at', null)->get();

        if (! $thread->hasParticipant($user->id)) {
            return response()->json([], Response::HTTP_FORBIDDEN);
        }

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
        $user = auth()->user();

        $thread = Thread::find($request->thread);

        if (empty($thread)) {
            if ($user->hasRole(Role::CREW)) {
                return response()->json([
                    'message' => 'You are not allowed to initiate a conversation with any producer.',
                ]);
            }

            $thread = app(CreateThread::class)->execute($user, $request);
        }
  
        $message = app(StoreMessage::class)->execute($thread, $user, $request->message);
        
        return response()->json([
                'message' => compact('message')
            ], 
            Response::HTTP_CREATED
        );
    }
}
