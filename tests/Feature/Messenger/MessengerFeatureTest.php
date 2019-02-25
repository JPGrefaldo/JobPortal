<?php

namespace Tests\Feature\Messenger;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use App\Models\Project;
use Cmgmyr\Messenger\Models\Thread;
use App\Models\Role;

class MessengerFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    public function test_project_thread_pivot_table()
    {
        $user = $this->createUser();
        
        $project = factory(Project::class)->create([
            'user_id' => $user->id,
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
    }

    public function test_admin_is_not_allowed_to_participate_in_the_threads()
    {
        $admin = $this->createAdmin();

        $thread = factory(Thread::class)->create([
            'subject' => 'Thread Test Subject'
        ]);

        $thread->users()->save($admin, [
            'user_id' => $admin->id
        ]);

        $this->assertTrue($admin->hasRole(Role::ADMIN));

        $this->actingAs($admin, 'api')
              ->get(route('messages.index', [
                      'thread' => $thread->id
                  ]
              ));

        $response = $this->actingAs($admin)
                         ->postJson(route('messages.store', [
                            'thread' => $thread->id,
                            'sender' => $admin->id,
                            'message' => 'Test Message'
                         ]));

        $response->assertJson([
            'error' => 'Admin is not allowed to participate on this thread'
        ]);
    }

    public function test_save_send_message()
    {
        $user = $this->createUser();

        $thread = factory(Thread::class)->create([
            'subject' => 'Thread Test Subject'
        ]);

        $thread->users()->save($user, [
            'user_id' => $user->id
        ]);

        $message = [
            'thread' => $thread->id,
            'sender' => $user->id,
            'message' => 'Test Message'
        ];

        $this->actingAs($user, 'api')
             ->get(route('messages.index', [
                    'thread' => $thread->id
                ]
             ));

        $response = $this->actingAs($user)
                         ->postJson('/api/threads', $message);

        $response->assertJsonFragment([
            'thread_id' => $thread->id,
            'user_id' => $user->id,
            'body' => 'Test Message'
        ]);
    }
}
