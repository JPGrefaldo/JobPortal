<?php

namespace App\Http\Controllers\API;

use App\Actions\Messenger\StoreMessage;
use App\Actions\Messenger\StoreParticipants;
use App\Actions\Messenger\StoreThread;
use App\Actions\Messenger\UpdateParticipants;
use App\Http\Controllers\Controller;
use App\Http\Resources\MessageResource;
use App\Models\Project;
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
    public function store(Project $project, Request $request)
    {
        $user = auth()->user();
      
        if ($user->hasRole(Role::CREW)) {
            return response()->json([
                'message' => 'You are not allowed to initiate a conversation with any producer.',
            ]);
        }

        $thread  = app(StoreThread::class)->execute($project, $request->subject);
        $message = app(StoreMessage::class)->execute($thread, $user, $request->message);
        
        app(StoreParticipants::class)->execute($thread, $request->recepients);

        return response()->json(
            compact('message'), 
            Response::HTTP_CREATED
        );
    }

    public function update(Thread $thread, Request $request)
    {
        $user    = auth()->user();
        $message = app(StoreMessage::class)->execute($thread, $user, $request->message);

        app(UpdateParticipants::class)->execute($thread, $user, $request->recepients);

        return response()->json(
            compact('message'), 
            Response::HTTP_OK
        );
    }
}
