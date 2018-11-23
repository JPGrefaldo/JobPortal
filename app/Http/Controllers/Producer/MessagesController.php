<?php

namespace App\Http\Controllers\Producer;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProducerStoreMessageRequest;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class MessagesController extends Controller
{
    public function store(ProducerStoreMessageRequest $request, Project $project)
    {
        // move this to request
        if (! $project->exists()) {
            return 'The project does not exist.';
        }

        // move this to request
        if (! Input::has('recipients')) {
            return 'You have to select a recipient.';
        }

        // find the crew with the given hash_id
        foreach (Input::get('recipients') as $recipient) {
            $recipientUser = User::whereHashId($recipient)->first();
            $recipentCrew = $recipientUser->crew;

            // move this to request
            if (! $project->contributors->contains($recipentCrew)) {
                return 'Crew does not belong to the project.';
            }

            // create thread
            $thread = Thread::create([
                'subject' => $request['subject'],
            ]);

            // create message
            Message::create([
                'thread_id' => $thread->id,
                'user_id' => Auth::id(),
                'body' => $request['message'],
            ]);

            // include sender in thread as participant
            Participant::create([
                'thread_id' => $thread->id,
                'user_id' => Auth::id(),
                'last_read' => new Carbon(),
            ]);

            $user = User::whereHashId($recipient)->first();
            $thread->addParticipant($user->id);
        }

        // TODO: check number of emails sent
        return str_plural('Message', count($request['recipients'])) . ' sent.';
    }
}
