<?php

namespace App\Actions\Messenger;

use Carbon\Carbon;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Thread;

class FetchNewMessages
{
    /**
     * @param User $user
     * @return Message
     */
    public function execute(User $user): Message
    {
        $threads = $user->threads()
                        ->forUserWithNewMessages($user->id)
                        ->latest('updated_at')
                        ->get();

        return $this->formatData($threads, $user);
    }

    /**
     * @param Thread $threads
     * @param User $user
     * @return Message|bool
     */
    private function formatData(Thread $threads, User $user)
    {
        $time = Carbon::now()->subMinutes(30);

        if ($threads->count() > 0) {
            return $threads->flatMap(function ($thread) use ($time, $user) {

                $messages = $thread->messages()
                                    ->where('created_at', '>', $time)
                                    ->where('user_id', '!=', $user->id)
                                    ->get()
                                    ->each(function ($message) use ($thread) {
                                        $thread = $thread->find($message->thread_id)->pluck('subject');
                                        $message['thread'] = $thread[0];

                                        return $message;
                                    });

                return $messages;
            });
        }

        return false;
    }
}
