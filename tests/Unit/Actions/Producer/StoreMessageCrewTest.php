<?php

namespace Tests\Unit\Actions\Producer;

use App\Actions\Producer\StoreMessageCrew;
use App\Models\Message;
use App\Models\Project;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class StoreMessageCrewTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    public function setUp(): void
    {
        parent::setup();
    }

    /**
     * @test
     * @covers \App\Actions\Producer\StoreMessageCrew::execute
     */
    public function executes()
    {
        // given
        $producer = $this->createProducer();
        $crew = $this->createCrew()->crew;
        $project = factory(Project::class)->create([
            'user_id' => $producer->id,
        ]);

        $data = new \stdClass;
        $data->subject = $producer->fullName;
        $data->message = 'Some message';
        $data->recipients = [$crew->user->id];

        // when
        app(StoreMessageCrew::class)->execute($project, $producer, $data);
        // then
        $this->assertCount(1, Thread::all());
        $this->assertCount(1, Message::all());

        $thread = Thread::first();
        $participants = User::whereNotIn('id', $thread->participantsUserIds($producer->id))->get();
        $this->assertCount(1, $participants);

        $this->assertDatabaseHas(
            'threads',
            [
                'subject' => $producer->full_name,
            ]
        );

        $this->assertDatabaseHas(
            'messages',
            [
                'thread_id' => $thread->id,
                'user_id'   => $producer->id,
                'body'      => 'Some message',
            ]
        );

        $this->assertArrayHas(
            [
                'first_name' => $crew->user->first_name,
                'last_name'  => $crew->user->last_name,
            ],
            $participants[0]->toArray()
        );
    }

    /**
     * @test
     * @covers \App\Actions\Producer\StoreMessageCrew::getThread
     */
    public function get_thread()
    {
        // given
        $producerUser = $this->createProducer();
        $crewUser = $this->createUser();
        $project = factory(Project::class)->create();
        $thread = $project->threads()->create([
            'subject' => 'asdf',
        ]);

        $thread->addParticipant([$producerUser->id, $crewUser->id]);

        $message = [
            'body'      => 'Some message',
            'thread_id' => $thread,
            'user_id'   => $producerUser->id,
        ];

        $thread->messages()->create($message);

        $project->threads()->attach($thread);

        // when
        $queriedThread = Thread::getByProjectAndParticipant($project, $crewUser);

        // then
        $this->assertEquals(
            $thread->subject,
            $queriedThread->subject
        );
    }

    protected function getData($producer)
    {
        $data = new \stdClass;
        $data->subject = $producer->fullName;
        $data->message = 'Some message';
        return $data;
    }
}
