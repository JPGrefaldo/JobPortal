<?php

namespace Tests\Feature\API;

use App\Actions\Messenger\FetchNewMessages;
use App\Http\Resources\MessageResource;
use App\Models\Crew;
use App\Models\Thread;
use App\Models\User;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
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
    public function indexAsCrew()
    {
        $this->withoutExceptionHandling();
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
    public function indexAsProducer()
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
        $thread = $this->seedThreadAndMessages();

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
        $thread = $this->seedThreadAndMessages();

        // when
        $response = $this->actingAs($user, 'api')
            ->getJson(route('messages.index', $thread));

        // then
        $response->assertForbidden();
    }

    private function seedThreadAndMessages()
    {
        $crew     = $this->createCrew();
        $producer = $this->createProducer();

        // Given we have a thread
        $thread = factory(Thread::class)->create([
            'subject' => 'Thread Test Subject',
        ]);

        // And participants
        $thread->addParticipant([$crew->id, $producer->id]);

        // And when a new reply in the thread is added (message)
        $replyFromCrew = [
            'thread_id' => $thread->id,
            'user_id'   => $crew->id,
            'body'      => 'Test Reply Message',
        ];

        $crew->messages()->create($replyFromCrew);

        return $thread;
    }
}
