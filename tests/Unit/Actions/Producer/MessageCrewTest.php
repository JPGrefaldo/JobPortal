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
     */
    public function execute()
    {
        // given
        $producerUser = factory(User::class)->create();
        $crew = factory(Crew::class)->create();
        $project = factory(Project::class)->create([
            'user_id' => $producerUser->id,
        ]);
        $data = $this->getData();
        $data['recipients'] = [
            $crew->user->hash_id,
        ];

        // when
        app(MessageCrew::class)->execute($data, $project, $producerUser);

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
                'user_id' => $producerUser->id,
                'body' => 'Some message',
            ]
        );
        $this->assertDatabaseHas(
            'participants',
            [
                'thread_id' => $thread->id,
                'user_id' => $producerUser->id,
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

    /**
     * @test
     */
    public function thread_is_not_duplicated_when_messaging_a_crew_twice()
    {
        // given
        $producerUser = factory(User::class)->create();
        $crew = factory(Crew::class)->create();
        $project = factory(Project::class)->create([
            'user_id' => $producerUser->id,
        ]);
        $project->contributors()->attach($crew);
        $data = $this->getData();
        $data['recipients'] = [
            $crew->user->hash_id,
        ];

        // when
        app(MessageCrew::class)->execute($data, $project, $producerUser);
        $this->assertCount(1, Thread::all());
        app(MessageCrew::class)->execute($data, $project, $producerUser);

        // then
        $this->assertCount(1, Thread::all());
        $this->assertCount(2, Message::all());
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
                'user_id' => $producerUser->id,
                'body' => 'Some message',
            ]
        );
        $this->assertDatabaseHas(
            'participants',
            [
                'thread_id' => $thread->id,
                'user_id' => $producerUser->id,
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

    /**
     * @test
     */
    public function get_thread()
    {
        // given
        $producerUser = factory(User::class)->create();
        $crewUser = factory(User::class)->create();
        $project = factory(Project::class)->create();
        $thread = factory(Thread::class)->create([
            'subject' => 'asdf'
        ]);

        $thread->addParticipant([$producerUser->id, $crewUser->id]);

        $message = factory(Message::class)->create([
            'thread_id' => $thread,
            'user_id' => $producerUser->id,
        ]);

        $thread->messages()->save($message);

        $project->threads()->attach($thread);

        // when
        $queriedThread = app(MessageCrew::class)->getThread($project, $crewUser);

        // then
        $this->assertEquals(
            $thread->subject,
            $queriedThread->subject
        );
    }

    protected function getData($overrides = [])
    {
        return [
            'subject' => 'Some subject',
            'message' => 'Some message',
        ];
    }
}
