<?php

namespace App\Http\Controllers;

use App\Models\User;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class MessagesController extends Controller
{
    public function store(Request $request)
    {
        dump($request->toArray());

        dump(auth()->user()->projects);
        if (! auth()->user()->projects()->where('id', $request['project_id'])->exists()) {
            return 'Message not sent.';
        }
        // check if project exist
        // check if recipentes exist


        // "// authorization\r",
        // must be producer
        // must be
        // "// validation\r",

        // "// general logic\r",
        $data = Input::all();

        // check if recipent is passed
        if (! Input::has('recipients')) {
            dump('hitting');
            return 'Message not sent.';
        }

        $recipient = User::find($input['recipient']);
        $crew = $recipient->crew;
        // check if crew applied to project
        if (! $crew->hasAppliedTo($project)) {
            return 'Message not sent.';
        }

        // create thread
        $thread = Thread::create([
            'subject' => $data['subject'],
        ]);

        // create message
        Message::create([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
            'body' => $input['message'],
        ]);

        // include sender in thread as participant
        Participant::create([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
            'last_read' => new Carbon,
        ]);

        $thread->addParticipant($input['recipeint']);
        return 'Message sent.';
    }
}
