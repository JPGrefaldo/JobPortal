<?php

namespace App\Actions\Messenger;

use Carbon\Carbon;
use Cmgmyr\Messenger\Models\Message;
use App\Models\User;

class FetchNewMessagesForNotification
{
    /**
     * @param User $user
     * @return Message
     */
    public function execute($user)
    {
        $time = Carbon::now()->subMinutes(30)->toDateTimeString();

        $threads = $user->threads()
                        ->with(['messages' => function($q) use ($time, $user){
                                $q->where([
                                    ['created_at', '>', $time],
                                    ['user_id', '!=', $user->id]
                                ]);
                            }
                        ])->get();

        return $threads;
    }
}
