<?php

namespace Tests\Feature\API;

use App\Models\Project;
use App\Models\Role;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class MessengerFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers App\Http\Controllers\API\MessageController::store
     */
    public function can_store_a_message()
    {
        $producer  = $this->createProducer();
        $response  = $this->mockStoreMessage($producer);

        $response->assertJsonFragment(['body'    => 'Some message']);
        $response->assertJsonFragment(['subject' => 'Some subject']);
    }

    /**
     * @test
     * @covers App\Http\Controllers\API\MessageController::update
     */
    public function can_reply_a_message()
    {
        $producer  = $this->createProducer();
        $response  = $this->mockStoreMessage($producer);
        $thread    = Thread::find(1);

        $data = [
            'message'   => 'Some Reply message',
            'recipient' => $producer->id,
        ];

        $response = $this->actingAs($producer, 'api')
            ->putJson(
                route(
                    'messenger.threads.messages.update',
                    ['thread' => $thread->id]
                ),
                $data
            );

        $response->assertJsonFragment([
            'thread_id' => $thread->id,
            'user_id'   => $producer->id,
            'body'      => 'Some Reply message',
        ]);
    }

    /**
     * @test
     * @covers App\Http\Controllers\API\MessageController::store
     */
    public function admin_is_not_allowed_to_participate_in_the_threads()
    {
        $data    = [];
        $admin   = $this->createAdmin();
        $project = factory(Project::class)->create();
        $thread  = $project->threads()->create([
            'subject' => 'Thread Test Subject',
        ]);

        $response = $this->actingAs($admin, 'api')
            ->postJson(
                route(
                    'messenger.project.messages.store',
                    ['project' => $project->id]
                ),
                $data
            );

        $response->assertJson([
            'message' => 'User does not have the right roles.',
        ]);

        $response = $this->actingAs($admin, 'api')
            ->putJson(
                route(
                    'messenger.threads.messages.update',
                    ['thread' => $thread->id]
                ),
                $data
            );

        $response->assertJson([
            'message' => 'User does not have the right roles.',
        ]);

        $this->assertTrue($admin->hasRole(Role::ADMIN));
    }

    /**
     * @test
     * @covers App\Http\Controllers\API\MessageController::store
     */
    public function crew_are_not_allowed_to_initiate_a_message_with_the_producer()
    {
        $crew    = $this->createCrew();
        $project = factory(Project::class)->create();

        $data = [
            'subject'   => 'Some subject',
            'message'   => 'Some message',
            'recepient' => [2,3],
        ];

        $response = $this->actingAs($crew, 'api')
            ->postJson(
                route(
                    'messenger.project.messages.store',
                    ['project' => $project->id]
                ),
                $data
            );

        $response->assertJson([
            'message' => 'You are not allowed to initiate a conversation with any producer.',
        ]);
    }

    private function mockStoreMessage($producer)
    {
        $recipient  = $this->createCrew();

        $project    = factory(Project::class)->create([
            'user_id' => $producer->id,
        ]);

        $data = [
            'subject'   => 'Some subject',
            'message'   => 'Some message',
            'recipient' => $recipient->id,
        ];

        $response = $this->actingAs($producer, 'api')
            ->postJson(route('messenger.project.messages.store', $project), $data);
        return $response;
    }
}
