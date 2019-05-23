<?php

namespace App\Actions\Messenger;

use Carbon\Carbon;
use Cmgmyr\Messenger\Models\Thread;

class FetchNewMessages
{
    /**
     * @param $user
     * @return bool
     */
    public function execute($user)
    {
        $threads = Thread::forUserWithNewMessages($user->id)
            ->latest('updated_at')
            ->get();

        return $this->formatData($threads, $user);
    }

    /**
     * @param $threads
     * @param $user
     * @return mixed
     */
    private function formatData($threads, $user)
    {
        if ($threads->count() > 0) {
            return $threads->flatMap(function ($thread) use ($user) {
                $time = Carbon::now()->subMinutes(30);

                $messages = $thread->messages()
                    ->where('created_at', '>', $time)
                    ->where('user_id', '!=', $user->id)
                    ->get()
                    ->each(function ($message) {
                        $thread = Thread::where('id', $message->thread_id)->pluck('subject');
                        $message['thread'] = $thread[0];

                        return $message;
                    });

                return $messages;
            });
        }

        return false;
    }
}
