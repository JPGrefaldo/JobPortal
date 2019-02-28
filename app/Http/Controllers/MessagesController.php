<?php

namespace App\Http\Controllers;

use App\Actions\Messenger\CreateMessage;
use App\Http\Resources\MessageResource;
use App\Models\Role;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Http\Request;
use App\Actions\Messenger\FetchNewMessages;
use App\Mail\UnreadMessageNotification;
use App\Models\User;
use App\Notifications\UnreadMessagesInThread;

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
        $thread = Thread::findOrFail($request->thread);
        $sender = auth()->user();
        $body = $request->message;

        $message = app(CreateMessage::class)->execute($thread->id, $sender->id, $body);
        
        return response()->json(compact('message'));
    }

    public function temp()
    {
        $user = User::find(1)->first();
        $user->notify(new UnreadMessagesInThread($user));
    }
}
