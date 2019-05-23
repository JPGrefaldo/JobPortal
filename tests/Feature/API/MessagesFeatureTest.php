<?php

namespace Tests\Feature\API;

use App\Http\Resources\MessageResource;
use App\Models\Crew;
use App\Models\Message;
use App\Models\Participant;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class MessagesFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers App\Http\Controllers\MessageController::index
     */
    public function index_as_crew()
    {
        // given
        $user = $this->createCrew();
        $thread = factory(Thread::class)->create();

        factory(Participant::class)->create([
            'thread_id' => $thread->id,
            'user_id'   => $user->id,
        ]);

        $messages = factory(Message::class, 3)->create([
            'thread_id' => $thread->id,
            'user_id'   => $user->id,
        ]);

        $this->assertCount(1, User::all());
        $this->assertCount(1, Crew::all());
        $this->assertCount(1, Thread::all());
        $this->assertCount(1, Participant::all());
        $this->assertCount(3, Message::all());

        // when
        $response = $this->actingAs($user, 'api')
            ->getJson(route('messages.index', $thread));

        // then
        $response->assertSuccessful();

        $json = $response->json();

        $resource = MessageResource::collection($messages);

        $resourceResponse = $resource->response()->getData(true);

        $this->assertEquals($resourceResponse['data'], $json['data']);
    }

    /**
     * @test
     * @covers App\Http\Controllers\MessageController::index
     */
    public function index_as_producer()
    {
        // given
        $user = $this->createProducer();
        $thread = factory(Thread::class)->create();

        factory(Participant::class)->create([
            'thread_id' => $thread->id,
            'user_id'   => $user->id,
        ]);

        $messages = factory(Message::class, 3)->create([
            'thread_id' => $thread->id,
            'user_id'   => $user->id,
        ]);

        $this->assertCount(1, User::all());
        $this->assertCount(1, Thread::all());
        $this->assertCount(1, Participant::all());
        $this->assertCount(3, Message::all());

        // when
        $response = $this->actingAs($user, 'api')
            ->getJson(route('messages.index', $thread));

        // then
        $response->assertSuccessful();

        $json = $response->json();

        $resource = MessageResource::collection($messages);

        $resourceResponse = $resource->response()->getData(true);

        $this->assertEquals($resourceResponse['data'], $json['data']);
    }

    /**
     * @test
     * @covers App\Http\Middleware::handle
     */
    public function crew_cant_see_messages_if_not_participant_of_thread()
    {
        // given
        $user   = $this->createCrew();
        $thread = $this->seedConversation();

        // when
        $response = $this->actingAs($user, 'api')
            ->getJson(route('messages.index', $thread));

        // then
        $response->assertForbidden();
    }

    /**
     * @test
     * @covers App\Http\Middlwware::handle
     */
    public function producer_cant_see_messages_if_not_participant_of_thread()
    {
        // given
        $user = $this->createProducer();
        $thread = $this->seedConversation();

        // when
        $response = $this->actingAs($user, 'api')
            ->getJson(route('messages.index', $thread));

        // then
        $response->assertForbidden();
    }

    private function seedConversation()
    {
        $crew     = $this->createCrew();
        $producer = $this->createProducer();

        $project = factory(Project::class)->create([
            'user_id' => $producer->id,
        ]);

        // Given we have a thread
        $thread = $project->threads()->create([
            'subject' => 'Thread Test Subject',
        ]);

        // Sender
        Participant::create([
            'thread_id' => $thread->id,
            'user_id'   => $producer->id,
            'last_read' => new Carbon(),
        ]);

        // Participant
        $thread->addParticipant($crew->id);

        // And when a new reply in the thread is added (message)
        $crew->messages()->create([
            'thread_id' => $thread->id,
            'body'      => 'Test Reply Message',
        ]);

        return $thread;
    }
}
