<?php

namespace Tests\Unit\Actions\Producer;

use App\Actions\Admin\MessageCrew;
use App\Models\Crew;
use App\Models\Project;
use App\Models\User;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class MessageCrewTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setup();
    }
    /**
     * @test
     * @covers \App\Actions\Admin\MessageCrew::execute
     */
    public function execute()
    {
        // given
        $producer = $this->createProducer();
        $crew = factory(Crew::class)->create();
        $project = factory(Project::class)->create([
            'user_id' => $producer->id,
        ]);
        $project->contributors()->attach($crew);
        $data = $this->getData();
        $data['recipients'] = [
            $crew->user->hash_id,
        ];

        // when
        app(MessageCrew::class)->execute($data, $producer);

        // then
        $this->assertCount(1, Thread::all());
        $this->assertCount(1, Message::all());
        $this->assertCount(2, Participant::all());

        $thread = Thread::first();

        $this->assertDatabaseHas(
            'threads',
            [
                'subject' => 'Some subject',
            ]
        );
        $this->assertDatabaseHas(
            'messages',
            [
                'thread_id' => $thread->id,
                'user_id' => $producer->id,
                'body' => 'Some message',
            ]
        );
        $this->assertDatabaseHas(
            'participants',
            [
                'thread_id' => $thread->id,
                'user_id' => $producer->id,
                // 'last_read' => new Carbon(),
            ]
        );

        $this->assertDatabaseHas(
            'participants',
            [
                'thread_id' => $thread->id,
                'user_id' => $crew->user->id,
                // 'last_read' => new Carbon,
            ]
        );
        // TODO: add email checks
    }

    protected function getData($overrides = [])
    {
        return [
            'subject' => 'Some subject',
            'message' => 'Some message',
        ];
    }
}
