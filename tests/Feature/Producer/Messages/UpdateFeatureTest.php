<?php

namespace Tests\Feature\Producer\Messages;

use App\Models\Crew;
use App\Models\Project;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

// TODO: restructure
class UpdateFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\MessagesController::update
     */
    public function producer_can_flag_a_message()
    {
        // $this->withExceptionHandling();
        // given
        $producerUser = $this->createProducer();
        $project = factory(Project::class)->create([
            'user_id' => $producerUser->id,
        ]);
        $crew = factory(Crew::class)->create();
        $project->contributors()->attach($crew);
        $thread = factory(Thread::class)->create();
        $thread->addParticipant($producerUser->id);
        $thread->addParticipant($crew->user->id);
        $message = factory(Message::class)->create([
            'thread_id' => $thread->id,
            'user_id'   => $crew->user->id,
        ]);

        // when
        $request = $this
            ->actingAs($producerUser)
            ->putJson(route('producer.messages.update', [$project, $message]));

        // then
        $request->assertSee('Message Flagged');
    }
}
