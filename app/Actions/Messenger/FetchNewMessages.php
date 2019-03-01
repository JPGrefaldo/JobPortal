<?php

namespace App\Actions\Messenger;

use Cmgmyr\Messenger\Models\Thread;
use Carbon\Carbon;

class FetchNewMessages
{
    public function execute($user)
    {
        $threads = Thread::forUserWithNewMessages($user->id)
                         ->latest('updated_at')
                         ->get();

        return $this->formatData($threads, $user);
    }

    private function formatData($threads, $user)
    {
        if($threads->count() > 0){
            return $threads->map(function ($thread) use ($user) {
    
                $time = Carbon::now()->addMinutes(30);

                return $thread->messages()
                              ->where('created_at', '<=', $time)
                              ->where('user_id', '!=', $user->id)
                              ->get()
                              ->each(function ($message){
                                  
                                  $thread = Thread::where('id', $message->thread_id)->first();
                                  $message['thread'] = (string)$thread->subject;

                                  return $message;
                              });
            });
        }

        return false;
    }
    
}