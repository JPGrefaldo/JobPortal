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
use App\Models\User;
use App\Actions\Messenger\FetchNewMessages;

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

    /**
     * @test
     * @covers App\Actions\Messenger\FetchNewMessages::execute
     */
    public function get_the_threads_that_has_new_messages()
    {
        $threads = $this->seedThreadAndMessages();

        $threads->map(function ($thread){
            $message = $thread->messages()->get()->toArray();

            $this->assertArrayHas([
                'thread_id' => $thread->id,
                'user_id' => 1,
                'body' => 'Test Reply Message'
            ], $message[0]);
        });
    }

    /**
     * @test
     * @covers App\Actions\Messenger\FetchNewMessages::dataFormat
     */
    public function format_email_notification()
    {
        $threads = $this->seedThreadAndMessages();

        $threads->flatMap(function($thread){
                    return $thread->messages()
                                    ->get()
                                    ->each(function($message){
                                        $thread = Thread::where('id', $message->thread_id)->pluck('subject');
                                        $message['thread'] = $thread[0];

                                        return $message;
                                    });
                })
                ->flatMap(function($emailFormat){
                    $this->assertEquals('Thread Test Subject', $emailFormat->thread);
                    $this->assertArrayHas(
                        [
                            "thread_id" => "1",
                            "user_id" => "1",
                            "body" => "Test Reply Message"
                        ], 
                        $emailFormat->toArray()
                    );
                });
    }

    private function seedThreadAndMessages()
    {
        $crew = $this->createCrew();
        $producer = $this->createProducer();

        $thread = factory(Thread::class)->create([
            'subject' => 'Thread Test Subject'
        ]);

        $thread->users()->save($producer, [
            'user_id' => $producer->id
        ]);

        $replyFromCrew = [
            'thread_id' => $thread->id,
            'user_id' => $crew->id,
            'body' => 'Test Reply Message'
        ];

        $crew->messages()->create($replyFromCrew);

        $threads = Thread::forUserWithNewMessages($producer->id)
                         ->latest('updated_at')
                         ->get();

        return $threads;
    }

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

        $oldReplyFromCrew = [
            'thread_id' => $thread->id,
            'user_id' => $crew->id,
            'body' => 'Test Old Reply Message',
            'created_at' => Carbon::today()->subMinutes(31)->toDateTimeString()
        ];

        $crew->messages()->create($replyFromCrew);
        $crew->messages()->create($oldReplyFromCrew);

        $time = Carbon::now()->subMinutes(30);

        $producerThreadMessage = $producer->threadsWithNewMessages()
                                           ->flatMap(function($thread) use ($time, $producer) {
                                               $messages = $thread->messages()
                                                             ->where('created_at', '>', $time)
                                                             ->where('user_id', '!=', $producer->id)
                                                             ->get();

                                                return $messages->toArray();
                                           });

        $this->assertEquals(1, count($producerThreadMessage));
        
        $this->assertArrayHas(
            [
                'thread_id' => 1,
                'user_id' => 1,
                'body' => 'Test Reply Message'
            ], 
            $producerThreadMessage[0]
        );
        
        $this->assertLessThan($producerThreadMessage[0]['created_at'],$time);
    }

    /**
     * @test
     * @covers App\Notifications\UnreadMessagesInThread::handle
     */
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

    /**
     * @test
     * @covers App\Console\Commands\SendUnreadMessagesEmail::handle
     */
    public function temp()
    {
        $users = User::all();

        $users->map(function($user){

            $messages = app(FetchNewMessages::class)->execute($user);

            if ($messages){
                $user->notify(new UnreadMessagesInThread($messages, $user));
            }
            
        });
    }
}
