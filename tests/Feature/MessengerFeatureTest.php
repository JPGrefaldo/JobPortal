<?php

namespace Tests\Unit\Notifications;

use App\Models\Role;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class MessengerFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers App\Http\Controllers\MessagesController::store
     */
    public function admin_is_not_allowed_to_participate_in_the_threads()
    {
        $admin = $this->createAdmin();

        $thread = factory(Thread::class)->create([
            'subject' => 'Thread Test Subject',
        ]);

        $thread->addParticipant(
            [
                'user_id' => $admin->id,
            ]
        );

        $this->assertTrue($admin->hasRole(Role::ADMIN));

        $this->actingAs($admin, 'api')
            ->get(route(
                'messages.index',
                [
                    'thread' => $thread->id,
                ]
              ));

        $response = $this->actingAs($admin)
            ->postJson(route('messages.store', [
                'thread'  => $thread->id,
                'sender'  => $admin->id,
                'message' => 'Test Message',
            ]));

        $response->assertJson([
            'message' => 'User does not have the right roles.',
        ]);
    }

    /**
     * @test
     * @covers App\Http\Controllers\MessagesController::store
     */
    public function crew_are_not_allowed_to_initiate_a_message_with_the_producer()
    {
        $crew = $this->createCrew();

        $thread = factory(Thread::class)->create([
            'subject' => 'Thread Test Subject',
        ]);

        $thread->addParticipant(
            [
                'user_id' => $crew->id,
            ]
        );

        $data = [
            'thread'  => $thread->id,
            'sender'  => $crew->id,
            'message' => 'Test Message',
        ];

        $this->actingAs($crew, 'api')
            ->get(route(
                'messages.index',
                [
                    'thread' => $thread->id,
                ]
             ));

        $response = $this->actingAs($crew)
            ->postJson(route('messages.store', $data));
        
        $response->assertJson([
            'message' => 'You are not allowed to message the producer',
        ]);
    }

    /**
     * @test
     * @covers App\Http\Controllers\MessagesController::store
     */
    public function store_message()
    {
        $user = $this->createProducer();

        $thread = factory(Thread::class)->create([
            'subject' => 'Thread Test Subject',
        ]);

        $thread->addParticipant(
            [
                'user_id' => $user->id,
            ]
        );

        $message = [
            'thread'  => $thread->id,
            'sender'  => $user->id,
            'message' => 'Test Message',
        ];

        $this->actingAs($user, 'api')
            ->get(route(
                'messages.index',
                [
                    'thread' => $thread->id,
                ]
             ));

        $response = $this->actingAs($user)
            ->postJson(route('messages.store', $message));

        $response->assertJsonFragment([
            'thread_id' => $thread->id,
            'user_id'   => $user->id,
            'body'      => 'Test Message',
        ]);
    }
}