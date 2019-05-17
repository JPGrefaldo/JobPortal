<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Thread;
use App\Models\Message;
use App\Models\Participant;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\ProjectThread;

class FakeMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fake:messages 
                                         {--sender=1   : USER ID - with a producer role that can be login to show the receiver message}
                                         {--receiver=2 : USER ID - With a crew role that can be login to show the sender message}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It will seed a message inluding a thread and participant. 
                              This is to test that the thread title is not always the sender\'s name';

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
        $user = $this->options();

        if (empty($user['sender']) && empty($user['receiver'])) {
            $this->info('--sender & --receiver should always be include with user\'s id');
        }

        $sender   = User::find($user['sender']);
        $receiver = User::find($user['receiver']);

        $project = factory(Project::class)->create([
            'user_id' => $sender->id,
        ]);

        $thread = Thread::create([
            'subject' => 'This is a test subject'
        ]);

        ProjectThread::create([
            'project_id' => $project->id,
            'thread_id'  => $thread->id
        ]);

        Message::create([
            'thread_id' => $thread->id,
            'user_id' => $sender->id,
            'body' => 'This is a test message',
        ]);

        // Sender
        Participant::create([
            'thread_id' => $thread->id,
            'user_id' => $sender->id,
            'last_read' => new Carbon(),
        ]);

        // Recipient
        $thread->addParticipant($receiver->id);

        $this->info('Done seeding message!');
    }
}
