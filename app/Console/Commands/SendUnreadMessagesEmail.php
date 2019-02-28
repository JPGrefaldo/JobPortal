<?php

namespace App\Console\Commands;

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
    protected $description = 'Send user email of their unread messages';

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
        //TODO: put last login field or pivot table which can be used to
        //get only the users who are currently online at least an hour or more
        $users = User::all();

        $users->flatMap(function($user){
            $user->notify(new UnreadMessagesInThread($user));
        });
    }
}
