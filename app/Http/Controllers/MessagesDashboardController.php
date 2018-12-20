<?php

namespace App\Http\Controllers;

use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Thread;

class MessagesDashboardController extends Controller
{
    public function index()
    {
        $threads = Thread::with('messages')->get();

        $messages = Message::all();

        $roles = auth()->user()->roles->pluck('name');

        return view(
            'messages-dashboard',
            compact(
                'threads',
                'messages',
                'roles'
            )
        );
    }
}
