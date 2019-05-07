<?php

namespace App\Http\Controllers\API\Producer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use App\Models\MessageMacro;
use Illuminate\Http\Request;
use App\Http\Requests\Producer\MessageMacroRequest;

class MessageMacrosController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $messages = $user->messageMacros()->get();

        return response()->json(
            [
                'message'  => "Sucessfully fetched all message macros",
                'messages' => $messages
            ],
            Response::HTTP_OK
        );
    }

    public function store(MessageMacroRequest $request)
    {
        $user = auth()->user();
        $message = $user->messageMacros()->create([
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