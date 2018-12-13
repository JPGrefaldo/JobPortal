<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Thread;

class MessagesDashboardController extends Controller
{
    public function index()
    {
        $projects = Project::all();

        $threads = Thread::all();

        $messages = Message::all();

        $roles = auth()->user()->roles;

        return view(
            'messages-dashboard',
            compact(
                'projects',
                'threads',
                'messages',
                'roles'
            )
        );
    }
}
