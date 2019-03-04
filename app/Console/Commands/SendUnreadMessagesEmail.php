<?php

namespace App\Console\Commands;

use App\Actions\Messenger\FetchNewMessages;
use App\Models\User;
use App\Notifications\UnreadMessagesInThread;
use Illuminate\Console\Command;

class SendUnreadMessagesEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:unreadmessages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify users with unread messages';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::all();

        $users->map(function($user){
            $messages = app(FetchNewMessages::class)->execute($user);

            $user->notify(new UnreadMessagesInThread($messages, $user));
        });
    }
}
