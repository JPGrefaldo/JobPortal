<?php

namespace App\Http\Controllers;

use App\Actions\Messenger\CreateMessage;
use App\Http\Resources\MessageResource;
use App\Models\ProjectThread;
use App\Models\Role;
use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MessagesController extends Controller
{
    protected $userIsParticipant = false;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Thread $thread)
    {   
        $authUser = auth()->user();
        $messages = $thread->messages()->with('user')->where('flagged_at', null)->get();

        $messages->map(function($message) use($authUser) {
            if ($message->user->id === $authUser->id) {
                $this->userIsParticipant = true;
            } 
        });

        if ($this->userIsParticipant) {
            return MessageResource::collection($messages);
        }

        return response()->json([], Response::HTTP_FORBIDDEN);
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
                    'message' => 'You are not allowed to message the producer',
                ]);
            }

            $thread = $user->project()->threads()->save([
                'subject' => $request->subject
            ]);

            ProjectThread::create([
                'project_id' => $user->project->id,
                'thread_id'  => $thread->id
            ]);

            //threads table
            $thread->create([
                'subject' => $request->subject
            ]);

            $thread->addParticipant($request->participant);
        }
        
        $body = $request->message;
        
        $message = app(CreateMessage::class)->execute($thread, $user, $body);
        
        return response()->json(compact('message'));
    }
}
