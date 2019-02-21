<?php

namespace Tests\Feature\Messenger;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use Cmgmyr\Messenger\Models\Message;
use App\Models\Project;
use Cmgmyr\Messenger\Models\Thread;
use App\Models\ProjectThread;
use App\Models\Role;

class MessengerFeatureTest extends TestCase
{

    use RefreshDatabase, SeedDatabaseAfterRefresh;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_messaging_flow()
    {
        $sender = $this->createUser();
        
        $project = factory(Project::class)->create([
            'user_id' => $sender->id,
            'title' => 'Project Test Title'
        ]);

        $thread = factory(Thread::class)->create([
            'subject' => 'Thread Test Subject'
        ]);

        $project->threads()->save($thread, [
            'thread_id' => $thread->id
        ]);

        $this->assertDatabaseHas('project_thread', [
            'project_id' => $project->id,
            'thread_id' => $thread->id
        ]);

        $this->assertFalse($sender->hasRole(Role::ADMIN));

        $message = [
            'thread_id' => $thread->id,
            'user_id' => $sender->id,
            'body' => 'Message Test Body'
        ];

        Message::create($message);

        $this->assertDatabaseHas('messages', $message);

    }
}
