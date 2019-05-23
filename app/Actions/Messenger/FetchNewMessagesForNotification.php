<?php

namespace App\Actions\Messenger;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class FetchNewMessagesForNotification
{
    public function execute($user): Collection
    {
        $time = Carbon::now()->subMinutes(30)->toDateTimeString();

        $threads = $user->threads()
                        ->with(['messages' => function ($q) use ($time, $user) {
                            $q->where([
                                ['created_at', '>', $time],
                                ['user_id', '!=', $user->id]
                            ]);
                        }
                        ])->get();

        return $threads;
    }
}
