<?php

namespace Tests\Feature\Producer;

use App\Models\Crew;
use App\Models\Project;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class CrewMessagingFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\MessageController::store
     */
    public function can_send_a_message()
    {
        $producer = $this->createProducer();
        $crew     = factory(Crew::class)->create();

        $project  = factory(Project::class)->create([
            'user_id' => $producer->id,
        ]);

        $project->contributors()->attach($crew);

        $data = $this->getData();
        $data['recipients'] =  [$crew->user->hash_id];

        $this->actingAs($producer)
            ->postJson(route('producer.messages.store', $project), $data)
            ->assertSee('Message sent.');
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\MessagesController::store
     */
    public function can_send_a_message_to_multiple_crews_who_applied()
    {
        $this->sendMessages();
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\MessagesController::store
     */
    public function only_producers_can_message()
    {
        // $this->withoutExceptionHandling();

        $crew = $this->createCrew();
        $project = factory(Project::class)->create();
        $data = $this->getData();

        $this->actingAs($crew)
            ->postJson(route('producer.messages.store', $project), $data)
            ->assertForbidden();
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\MessageController::store
     */
    public function producer_must_own_project()
    {
        $producer = $this->createProducer();
        $project = factory(Project::class)->create();

        $this->actingAs($producer)
            ->postJson(route('producer.messages.store', $project))
            ->assertForbidden();
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\MessageController::store
     */
    public function cant_send_message_if_required_fields_are_empty()
    {
        // $this->withoutExceptionHandling();

        $producer = $this->createProducer();
        $project = factory(Project::class)->create([
            'user_id' => $producer->id,
        ]);

        $data = [
            'subject'    => '',
            'message'    => '',
            'recipients' => '',
        ];

        $response = $this
            ->actingAs($producer)
            ->postJson(route('producer.messages.store', $project), $data);

        $response->assertJson([
            'message' => 'The given data was invalid.',
            'errors'  => [
                'message'    => ['The message field is required.'],
                'recipients' => ['The recipients field is required.'],
            ],
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\MessageController::store
     */
    public function cant_send_message_to_crews_who_has_not_applied()
    {
        // $this->withoutExceptionHandling();

        $producer = $this->createProducer();
        $randomCrews = factory(Crew::class, 3)->create();

        $project = factory(Project::class)->create([
            'user_id' => $producer->id,
        ]);

        $data = $this->getData();
        $data['recipients'] = $randomCrews->map(function ($crew) {
            return $crew->user->hash_id;
        });

        $response = $this
            ->actingAs($producer)
            ->postJson(route('producer.messages.store', $project), $data);

        $response->assertJson([
            'message' => 'The given data was invalid.',
            'errors'  => [
                'recipients' => ['The selected recipients is invalid.'],
            ],
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\MessageController::store
     */
    public function crew_should_receive_the_message_individually()
    {
        // $this->withoutExceptionHandling();

        $this->sendMessages();

        $threads = Thread::all();

        $this->assertCount(3, $threads);

        foreach ($threads as $thread) {
            $users = User::find($thread->participantsUserIds());

            $this->assertCount(1, $users);

            foreach ($users as $user) {
                $thread->userUnreadMessages($user->id)->map(function ($message) {
                    $this->assertEquals('Some message', $message->body);
                });
            }
        }
    }

    private function getData()
    {
        return [
            'message' => 'Some message',
        ];
    }

    private function sendMessages()
    {
        $producer = $this->createProducer();
        $crews    = factory(Crew::class, 3)->create();

        $project  = factory(Project::class)->create([
            'user_id' => $producer->id,
        ]);

        $project->contributors()->attach($crews);

        $data = $this->getData();
        $data['recipients'] = $crews->map(function ($crew) {
            return $crew->user->hash_id;
        });

        $this->actingAs($producer)
            ->postJson(route('producer.messages.store', $project), $data)
            ->assertSee('Messages sent.');
    }
}
