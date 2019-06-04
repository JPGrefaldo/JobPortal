<?php

namespace App\Http\Controllers\API;

use App\Actions\Messenger\StoreMessage;
use App\Actions\Messenger\StoreParticipants;
use App\Actions\Messenger\StoreThread;
use App\Actions\Messenger\UpdateParticipants;
use App\Actions\Producer\StoreMessageCrew;
use App\Http\Controllers\Controller;
use App\Http\Requests\Producer\Message\StoreMessageCrewRequest;
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
     * @return Response
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
     * Store a new project thread and its message and participant(recipient).
     *
     * @param Request $request
     * @return Response
     */
    public function store(Project $project, Request $request)
    {
        $user = auth()->user();
        if ($user->hasRole(Role::CREW)) {
            return response()->json([
                'message' => 'You are not allowed to initiate a conversation with any producer.',
            ]);
        }

        $thread = app(StoreThread::class)->execute($project, $request->subject);
        $message = app(StoreMessage::class)->execute($thread, $user, $request->message);

        app(StoreParticipants::class)->execute($thread, $user, $request->recipient);

        return response()->json(
            compact('message'),
            Response::HTTP_CREATED
        );
    }

    /**
     * Store a new project, thread and its message and participants(recepients).
     *
     * @param Project $project
     * @param Request $request
     * @return Response
     */
    public function storeCrew(Project $project, StoreMessageCrewRequest $request)
    {
        $user = auth()->user();

        app(StoreMessageCrew::class)->execute($project, $user, $request);

        return response()->json(
            ['message' => "Successfully save the crews' message"],
            Response::HTTP_CREATED
        );
    }

    /**
     * Update thread participants and store message replies
     *
     * @param Thread $thread
     * @param Request $request
     * @return Response
     */
    public function update(Thread $thread, Request $request)
    {
        $user = auth()->user();
        $message = app(StoreMessage::class)->execute($thread, $user, $request->message);

        app(UpdateParticipants::class)->execute($thread, $user, $request->recipient);

        return response()->json(
            compact('message'),
            Response::HTTP_OK
        );
    }
}
