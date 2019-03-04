<?php

namespace Tests\Unit\Actions\Messenger;

use Carbon\Carbon;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use App\Actions\Messenger\FetchNewMessages;

class FetchNewMessagesTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers App\Actions\Messenger\FetchNewMessages::execute
     */
    public function get_the_threads_that_has_new_messages()
    {
        // Given and When please refer to seedThreadAndMessages()
        $threads = $this->seedThreadAndMessages();
        
        // Then we map through the thread's message(s)
        $threads->map(function ($thread){
            $message = $thread->messages()->get();

            // And then assert if the thread's message was
            // fetch  successfully
            $this->assertArrayHas([
                'thread_id' => $thread->id,
                'user_id' => 1,
                'body' => 'Test Reply Message'
            ], $message->toArray());
        });
    }

    /**
     * @test
     * @covers App\Actions\Messenger\FetchNewMessages::dataFormat
     */
    public function format_email_notification()
    {
        // Given and When please refer to seedThreadAndMessages()
        $threads = $this->seedThreadAndMessages();

        // Then we loop through thread's messages
        $threads->flatMap(function($thread){
                    return $thread->messages()
                                    ->get()
                                    ->each(function($message){
                                        // And then get the thread subject
                                        $thread = Thread::where('id', $message->thread_id)->pluck('subject');
                                        
                                        // And then add the thread subject to the messages
                                        $message['thread'] = $thread[0];

                                        // Then return them to display them in the email notifiaction
                                        return $message;
                                    });
                })
                ->flatMap(function($emailFormat){

                    // Then we assert if we succesfully added the thread subject to the messages
                    $this->assertEquals('Thread Test Subject', $emailFormat->thread);
                    
                    // And assert if the return email format is what we expected to be
                    $this->assertArrayHas(
                        [
                            "thread_id" => 1,
                            "user_id" => 1,
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

        // Given we have a thread
        $thread = factory(Thread::class)->create([
            'subject' => 'Thread Test Subject'
        ]);

        // And the thread owner is producer
        $thread->addParticipant( 
            [
                'user_id' => $producer->id
            ]
        );

        // And when a new reply in the thread is added (message)
        $replyFromCrew = [
            'thread_id' => $thread->id,
            'user_id' => $crew->id,
            'body' => 'Test Reply Message'
        ];

        $crew->messages()->create($replyFromCrew);
        
        // Then get all new thread with new messages
        $threads = app(FetchNewMessages::class)->execute($producer);
        
        // Then return the threads with their messages
        return $threads;
    }

    /**
     * @test
     * @covers App\Actions\Messenger\FetchNewMessages::dataFormat
     */
    public function get_thread_messages_that_are_added_less_than_30_minutes_ago()
    {
        $crew = $this->createCrew();
        $producer = $this->createProducer();

        //Given seedThreadMessagesAndReplies()
        $this->seedThreadMessagesAndReplies($crew, $producer);

        // And given our time constraint for messages posted
        $time = Carbon::now()->subMinutes(30);

        // Given the scheduled notification is fired
        // and we map through all the users
        
        // Then we map through the user's thread with new message
        $producer->threadsWithNewMessages()
                 ->flatMap(function($thread) use ($time, $producer) {
                    // And then get all the messages that are posted less
                    // than 30 mins. ago and return them
                    return $thread->messages()
                                  ->where('created_at', '>', $time)
                                  ->where('user_id', '!=', $producer->id)
                                  ->get()
                                  ->toArray();
                 })
                 //Then we map through the user's thread messages
                 ->flatmap(function($message) use($time) {
                    // Then we assert each of them that
                    // it got only the new reply
                    $this->assertArrayHas(
                        [
                            'thread_id' => 1,
                            'user_id' => 1,
                            'body' => 'Test Reply Message'
                        ], 
                        $message
                    );
                    // And then compare the creation time to make sure that it got
                    // only the messages that are posted not more than 30 mins. ago
                    $this->assertLessThan($message['created_at'], $time);
                });
    }

    private function seedThreadMessagesAndReplies($crew, $producer)
    {
        // Given we have a thread
        $thread = factory(Thread::class)->create([
            'subject' => 'Thread Test Subject'
        ]);

        // And the thread owner is the producer
        $thread->addParticipant(
            [
                'user_id' => $producer->id
            ]
        );

        // And given the producer has posted a message
        // on his thread
        $message = [
            'thread_id' => $thread->id,
            'user_id' => $producer->id,
            'body' => 'Test Message'
        ];

        $producer->messages()->create($message);
        
        // And given we have two replies from the crew
        // a new one and old reply which is posted 31 mins. ago
        $replyFromCrew = [
            'thread_id' => $thread->id,
            'user_id' => $crew->id,
            'body' => 'Test Reply Message'
        ];

        $oldReplyFromCrew = [
            'thread_id' => $thread->id,
            'user_id' => $crew->id,
            'body' => 'Test Old Reply Message',
            'created_at' => Carbon::now()->subMinutes(31)
        ];

        $crew->messages()->create($replyFromCrew);
        $crew->messages()->create($oldReplyFromCrew);
    }
}