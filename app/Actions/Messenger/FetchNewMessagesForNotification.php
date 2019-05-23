<?php

namespace App\Actions\Messenger;

use Carbon\Carbon;
<<<<<<< HEAD
use Illuminate\Support\Collection;

class FetchNewMessagesForNotification
{
    public function execute($user): Collection
=======
use Cmgmyr\Messenger\Models\Message;
use App\Models\User;

class FetchNewMessagesForNotification
{
    /**
     * @param User $user
     * @return Message
     */
    public function execute($user)
>>>>>>> 362296031280a223704794976eb648cd439a1f9f
    {
        $time = Carbon::now()->subMinutes(30)->toDateTimeString();

        $threads = $user->threads()
<<<<<<< HEAD
                        ->with(['messages' => function ($q) use ($time, $user) {
                            $q->where([
                                ['created_at', '>', $time],
                                ['user_id', '!=', $user->id]
                            ]);
                        }
=======
                        ->with(['messages' => function($q) use ($time, $user){
                                $q->where([
                                    ['created_at', '>', $time],
                                    ['user_id', '!=', $user->id]
                                ]);
                            }
>>>>>>> 362296031280a223704794976eb648cd439a1f9f
                        ])->get();

        return $threads;
    }
}
