<?php

namespace Tests\Unit\Actions\Messenger;

use App\Actions\Messenger\FetchNewMessages;
use App\Models\Message;
use App\Models\Thread;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class FetchNewMessagesTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Actions\Messenger\FetchNewMessages::execute
     */
    public function get_the_threads_that_has_new_messages()
    {
        // Given and When please refer to seedThreadAndMessages()
        $threads = $this->seedThreadAndMessages();

        // Then we map through the thread's message(s)
        $threads->map(function ($thread) {
            $thread->messages->map(function ($message) use($thread) {
                $this->assertArrayHas([
                    'thread_id' => $thread->id,
                    'user_id'   => 1,
                    'body'      => 'Test Reply Message',
                ], $message->toArray());
            });
        });
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

        // Then get all new thread with new messages
        $threads = app(FetchNewMessages::class)->execute($producer);

        // Then return the threads with their messages
        return $threads;
    }
}
