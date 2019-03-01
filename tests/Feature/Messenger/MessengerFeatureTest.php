<?php

namespace Tests\Feature\Messenger;

use App\Models\Role;
use App\Notifications\UnreadMessagesInThread;
use Carbon\Carbon;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class MessengerFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    public function test_admin_is_not_allowed_to_participate_in_the_threads()
    {
        $admin = $this->createAdmin();

        $thread = factory(Thread::class)->create([
            'subject' => 'Thread Test Subject'
        ]);

        $thread->users()->save($admin, [
            'user_id' => $admin->id
        ]);

        $this->assertTrue($admin->hasRole(Role::ADMIN));

        $this->actingAs($admin, 'api')
              ->get(route('messages.index', [
                      'thread' => $thread->id
                  ]
              ));

        $response = $this->actingAs($admin)
                         ->postJson(route('messages.store', [
                            'thread' => $thread->id,
                            'sender' => $admin->id,
                            'message' => 'Test Message'
                         ]));

        $response->assertJson([
            'message' => 'User does not have the right roles.'
        ]);
    }

    public function test_save_send_message()
    {
        $user = $this->createProducer();

        $thread = factory(Thread::class)->create([
            'subject' => 'Thread Test Subject'
        ]);

        $thread->users()->save($user, [
            'user_id' => $user->id
        ]);

        $message = [
            'thread' => $thread->id,
            'sender' => $user->id,
            'message' => 'Test Message'
        ];

        $this->actingAs($user, 'api')
             ->get(route('messages.index', [
                    'thread' => $thread->id
                ]
             ));

        $response = $this->actingAs($user)
                         ->postJson(route('messages.store', $message));

        $response->assertJsonFragment([
            'thread_id' => $thread->id,
            'user_id' => $user->id,
            'body' => 'Test Message'
        ]);
    }

    //test should_not_get_threads_that_are_read_more_than_30_minutes

    public function test_get_thread_messages_that_are_added_less_than_30_minutes_ago()
    {
        $crew = $this->createCrew();
        $producer = $this->createProducer();

        $thread = factory(Thread::class)->create([
            'subject' => 'Thread Test Subject'
        ]);

        $thread->users()->save($producer, [
            'user_id' => $producer->id
        ]);

        $message = [
            'thread_id' => $thread->id,
            'user_id' => $producer->id,
            'body' => 'Test Message'
        ];

        $producer->messages()->create($message);
        
        $replyFromCrew = [
            'thread_id' => $thread->id,
            'user_id' => $crew->id,
            'body' => 'Test Reply Message'
        ];

        $crew->messages()->create($replyFromCrew);

        $time = Carbon::now()->addMinutes(30);

        $producerThreadMessage = $producer->threadsWithNewMessages()
                                           ->map(function($thread) use ($time, $producer) {
                                               return $thread->messages()
                                                             ->where('created_at', '<=', $time)
                                                             ->where('user_id', '!=', $producer->id)
                                                             ->first();
                                           })
                                           ->map(function ($thread) {
                                               return $thread->toArray();
                                           });

        $this->assertArrayHas($replyFromCrew, $producerThreadMessage[0]);
        $this->assertLessThan($time, $producerThreadMessage[0]['created_at']);

    }

    public function test_sending_email_notification()
    {
        $producer = $this->createProducer();

        $message = [
            'body' => 'This is a test message'
        ];

        Notification::fake();

        Notification::assertNothingSent();

        $producer->notify(new UnreadMessagesInThread($message, $producer));

        Notification::assertSentTo([$producer], UnreadMessagesInThread::class);
    }
}
