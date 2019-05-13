<?php

namespace Tests\Feature\API;

use App\Http\Resources\MessageResource;
use App\Models\Crew;
use App\Models\User;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use Cmgmyr\Messenger\Models\Thread;
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
        // given
        $user = $this->createCrew();
        $crew = $user->crew;
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
        // $this->withoutExceptionHandling();

        // given
        $user = $this->createCrew();
        $thread = factory(Thread::class)->create();

        // when
        $response = $this->actingAs($user, 'api')
            ->getJson(route('messages.index', $thread));

        // then
        $response->assertForbidden();

        // given
        factory(Participant::class)->create([
            'thread_id' => $thread->id,
            'user_id'   => $user->id,
        ]);

        // when
        $response = $this->actingAs($user, 'api')
            ->getJson(route('messages.index', $thread));

        // then
        $response->assertSuccessful();
    }

    /**
     * @test
     * @covers App\Http\Middlwware::handle
     */
    public function producer_cant_see_messages_if_not_participant_of_thread()
    {
        // $this->withoutExceptionHandling();

        // given
        $user = $this->createProducer();
        $thread = factory(Thread::class)->create();

        // when
        $response = $this->actingAs($user, 'api')
            ->getJson(route('messages.index', $thread));

        // then
        $response->assertForbidden();

        // given
        factory(Participant::class)->create([
            'thread_id' => $thread->id,
            'user_id'   => $user->id,
        ]);

        // when
        $response = $this->actingAs($user, 'api')
            ->getJson(route('messages.index', $thread));

        // then
        $response->assertSuccessful();
    }
}
