<?php

use App\Models\Message;
use App\Models\Participant;
use App\Models\Thread;

return [

    // 'user_model' => App\Models\User::class,

    'message_model' => Message::class,

    'participant_model' => Participant::class,

    'thread_model' => Thread::class,

    /**
     * Define custom database table names - without prefixes.
     */
    'messages_table' => null,

    'participants_table' => null,

    'threads_table' => null,
];
