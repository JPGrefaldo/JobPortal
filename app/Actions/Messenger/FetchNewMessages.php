<?php

namespace App\Actions\Messenger;

use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Support\Facades\Auth;

class FetchNewMessages
{
    public function execute($user)
    {
        $threads = Thread::forUserWithNewMessages($user->id)
                         ->latest('updated_at')
                         ->get();

        return $this->formatData($threads);
    }

    private function formatData($threads)
    {
        $threadMessages = $threads->map(function($thread){

            $messages = $thread->messages()
                               ->where('user_id', '!=', Auth::id())
                               ->get();

            return $messages->map(function($message){

                $thread = Thread::where('id', $message->thread_id)->first();
                $message['thread'] = (string)$thread->subject;
                return $message;

            });
        });

        return $threadMessages;
    }
    
}