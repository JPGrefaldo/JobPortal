<?php

namespace App\Console\Commands;

use App\Models\Message;
use App\Models\Participant;
use App\Models\Project;
use App\Models\ProjectThread;
use App\Models\Role;
use App\Models\Thread;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class FakeMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fake:messages
                                         {--sender=   : USER ID - with a producer role that can be login to show the receiver message}
                                         {--receiver= : USER ID - With a crew role that can be login to show the sender message}';

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

        if (empty($user['sender']) || empty($user['receiver'])) {
            $this->info('Creating new 2 users with a producer and crew role respectively');
            $sender   = $this->createUser();
            $receiver = $this->createUser('crew');
        } else {
            $sender   = User::find($user['sender']);
            $receiver = User::find($user['receiver']);
        }

        if (! $sender->hasRole(Role::PRODUCER)) {
            $this->error("The sender's role is {$sender->getRoleNames()}, not a Producer");
            return;
        }

        if (! $receiver->hasRole(Role::CREW)) {
            $this->error("The receiver's role is {$receiver->getRoleNames()}, not a Crew");
            return;
        }

        $project = factory(Project::class)->create([
            'user_id' => $sender->id,
        ]);

        $thread = Thread::create([
            'subject' => 'This is a test subject',
        ]);

        ProjectThread::create([
            'project_id' => $project->id,
            'thread_id'  => $thread->id,
        ]);

        Message::create([
            'thread_id' => $thread->id,
            'user_id'   => $sender->id,
            'body'      => 'This is a test message',
        ]);

        Message::create([
            'thread_id' => $thread->id,
            'user_id'   => $receiver->id,
            'body'      => 'This is a Reply message',
        ]);

        // Sender
        Participant::create([
            'thread_id' => $thread->id,
            'user_id'   => $sender->id,
            'last_read' => new Carbon(),
        ]);

        // Recipient
        $thread->addParticipant($receiver->id);

        $this->info('Done seeding message!');
    }

    private function createUser($role = 'producer')
    {
        $user = factory(User::class)->create();
        $role === 'producer' ? $user->assignRole(Role::PRODUCER) : $user->assignRole(Role::CREW);

        return $user;
    }
}
