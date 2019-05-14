<?php

namespace App\Http\Controllers\API\Producer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Producer\Message\MessageTemplateRequest;
use Illuminate\Http\Response;

class MessageTemplatesController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $messages = $user->messageTemplates()->get();

        return response()->json(
            [
                'message'  => "Sucessfully fetched all message templates",
                'messages' => $messages
            ],
            Response::HTTP_OK
        );
    }

    public function store(MessageTemplateRequest $request)
    {
        $user = auth()->user();
        $message = $user->messageTemplates()->create([
            'message' => $request->message
        ]);

        return response()->json(
            [
                'message'  => "Sucessfully save message template",
                'messages' => $message
            ],
            Response::HTTP_CREATED
        );
    }
}