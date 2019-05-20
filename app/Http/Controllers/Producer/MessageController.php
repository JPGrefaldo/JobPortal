<?php

namespace App\Http\Controllers\Producer;

use App\Actions\Admin\MessageCrew;
use App\Http\Controllers\Controller;
use App\Http\Requests\Producer\Message\UpdateRequest;
use App\Http\Requests\ProducerStoreMessageRequest;
use App\Models\Message;
use App\Models\Project;
use Illuminate\Support\Str;

class MessageController extends Controller
{
    public function store(ProducerStoreMessageRequest $request, Project $project)
    {
        app(MessageCrew::class)->execute($request, $project, auth()->user());

        return Str::plural('Message', count($request['recipients'])) . ' sent.';
    }

    public function update(UpdateRequest $request, Project $project, Message $message)
    {
        // TODO: notify the admin
        // TODO: email admin
        return 'Message Flagged.';
    }
}
