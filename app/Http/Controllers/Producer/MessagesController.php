<?php

namespace App\Http\Controllers\Producer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Producer\Message\UpdateRequest;
use App\Http\Requests\ProducerStoreMessageRequest;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{
    public function store(ProducerStoreMessageRequest $request, Project $project)
    {
        $recipients = User::whereIn('hash_id', $request['recipients']);
        foreach ($recipients as $recipient) {
            $thread = Thread::create([
                'subject' => $request['subject'],
            ]);

            Message::create([
                'thread_id' => $thread->id,
                'user_id' => Auth::id(),
                'body' => $request['message'],
            ]);

            Participant::create([
                'thread_id' => $thread->id,
                'user_id' => Auth::id(),
                'last_read' => new Carbon(),
            ]);

            $thread->addParticipant($recipient->id);
        }

        // TODO: check number of emails sent
        // TODO: queue send emails
        return str_plural('Message', count($request['recipients'])) . ' sent.';
    }

    public function update(UpdateRequest $request, Project $project, Message $message)
    {
        // TODO: notify the admin
        // TODO: email admin
        return 'Message Flagged.';
    }
}
