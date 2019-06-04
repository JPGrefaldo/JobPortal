<?php

namespace Tests\Unit\Actions\Messenger;

use App\Actions\Messenger\FetchNewMessagesForNotification;
use App\Models\Message;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class FetchNewMessagesForNotificationTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers App\Actions\Messenger\FetchNewMessages::execute
     */
    public function get_thread_messages_that_are_added_less_than_30_minutes_ago()
    {
        $crew     = $this->createCrew();
        $producer = $this->createProducer();

        $this->seed_thread_messages_and_replies($crew, $producer);

        $threads = app(FetchNewMessagesForNotification::class)->execute($producer);

        $threads->map(function ($thread) {
            $thread->messages->map(function ($message) {
                $this->assertArrayHas(
                    [
                        'thread_id' => 1,
                        'user_id'   => 1,
                        'body'      => 'Test Reply Message',
                    ],
                    $message->toArray()
                );

                $time = Carbon::now()->subMinutes(30)->toDateTimeString();
                $this->assertLessThan($message['created_at'], $time);
            });
        });
    }

    /**
     * @param User $crew
     * @param User $producer
     * @return void
     */
    private function seed_thread_messages_and_replies(User $crew, User $producer)
    {
        // Given we have a thread
        $thread = factory(Thread::class)->create([
            'subject' => 'Thread Test Subject',
        ]);

        // And the thread owner is the producer
        $thread->addParticipant(
            [
                'user_id' => $producer->id,
            ]
        );

        // And given the producer has posted a message
        // on his thread
        $message = [
            'thread_id' => $thread->id,
            'user_id'   => $producer->id,
            'body'      => 'Test Message',
        ];

        $thread->messages()->create($message);

        // And given we have two replies from the crew
        // a new one and old reply which is posted 31 mins. ago
        $replyFromCrew = [
            'thread_id'  => $thread->id,
            'user_id'    => $crew->id,
            'body'       => 'Test Reply Message',
            'created_at' => Carbon::now(),
        ];

        $oldReplyFromCrew = [
            'thread_id'  => $thread->id,
            'user_id'    => $crew->id,
            'body'       => 'Test Old Reply Message',
            'created_at' => Carbon::now()->subMinutes(31),
        ];

        Message::insert([$oldReplyFromCrew, $replyFromCrew]);
    }
}
