<?php

namespace App\Http\Controllers\Producer;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProducerStoreMessageRequest;
use App\Models\Role;

class MessagesController extends Controller
{
    public function store(ProducerStoreMessageRequest $request)
    {
        if (! auth()->user()->whereHas('roles', function ($query) {
            $query->where('name', Role::PRODUCER);
        })->get()) {
            return 'You are not a producer';
        }

        $request->validate();

        if (! $project->exists()) {
            return 'The project does not exist.';
        }

        if (! Input::has('recipients')) {
            return 'You have to select a recipeint.';
        }

        // find the crew with the given hash_id
        $crew = $recipient->crew;

        if (! $crew->belongsToProject()) {
            return 'Crew does not belong to the project.';
        }

        // get user instance of crew
        $recipient = User::find($input['recipient']);


        // check if crew applied to project
        if (! $crew->hasAppliedTo($project)) {
            return 'Message not sent.';
        }

        // message the fool
        $data = Input::all();

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
