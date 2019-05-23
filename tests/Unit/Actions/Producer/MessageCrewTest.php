<?php

namespace Tests\Unit\Actions\Producer;

use App\Actions\Admin\MessageCrew;
use App\Models\Crew;
use App\Models\Message;
use App\Models\Participant;
use App\Models\Project;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class MessageCrewTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    public function setUp(): void
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
        $producer   = $this->createProducer();
        $crew       = factory(Crew::class)->create();
        $project    = factory(Project::class)->create([
            'user_id' => $producer->id,
        ]);

        $data = $this->getData();
        $data['recipients'] = [
            $crew->user->hash_id,
        ];

        // when
        app(MessageCrew::class)->execute($data, $project, $producer);

        // then
        $this->assertCount(1, Thread::all());
        $this->assertCount(1, Message::all());
        $this->assertCount(1, Participant::all());

        $thread = Thread::first();

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

        $this->assertDatabaseHas(
            'participants',
            [
                'thread_id' => $thread->id,
                'user_id'   => $crew->user->id,
            ]
        );
    }

    /**
     * @test
     * @covers \App\Actions\Admin\MessageCrew::execute
     */
    public function thread_is_not_duplicated_when_messaging_a_crew_twice()
    {
        // $this->withExceptionHandling();
        // given
        $producer   = $this->createUser();
        $crew       = factory(Crew::class)->create();
        $project    = factory(Project::class)->create([
            'user_id' => $producer->id,
        ]);

        $project->contributors()->attach($crew);

        $data = $this->getData();
        $data['recipients'] = [
            $crew->user->hash_id,
        ];

        // when
        app(MessageCrew::class)->execute($data, $project, $producer);
        $this->assertCount(1, Thread::all());
        app(MessageCrew::class)->execute($data, $project, $producer);

        // then
        $this->assertCount(1, Thread::all());
        $this->assertCount(2, Message::all());
        $this->assertCount(1, Participant::all());

        $thread = Thread::first();

        $this->assertDatabaseHas(
            'threads',
            [
                'subject' => $producer->fullName,
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

        $this->assertDatabaseHas(
            'participants',
            [
                'thread_id' => $thread->id,
                'user_id'   => $crew->user->id,
            ]
        );
    }

    /**
     * @test
     * @covers \App\Actions\Admin\MessageCrew::getThread
     */
    public function get_thread()
    {
        // given
        $producerUser = $this->createProducer();
        $crewUser = $this->createUser();
        $project = factory(Project::class)->create();
        $thread = factory(Thread::class)->create([
            'subject' => 'asdf',
        ]);

        $thread->addParticipant([$producerUser->id, $crewUser->id]);

        $message = factory(Message::class)->create([
            'thread_id' => $thread,
            'user_id'   => $producerUser->id,
        ]);

        $thread->messages()->save($message);

        $project->threads()->attach($thread);

        // when
        $queriedThread = Thread::getByProjectAndParticipant($project, $crewUser);

        // then
        $this->assertEquals(
            $thread->subject,
            $queriedThread->subject
        );
    }

    protected function getData($overrides = [])
    {
        return [
            'message' => 'Some message',
        ];
    }
}
