<?php

namespace Tests\Unit\Actions\Messenger;

use Carbon\Carbon;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class FetchNewMessagesTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

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

        $thread = factory(Thread::class)->create([
            'subject' => 'Thread Test Subject'
        ]);

        $thread->addParticipant( 
            [
                'user_id' => $producer->id
            ]
        );

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

    /**
     * @test
     * @covers App\Actions\Messenger\FetchNewMessages::dataFormat
     */
    public function get_thread_messages_that_are_added_less_than_30_minutes_ago()
    {
        $crew = $this->createCrew();
        $producer = $this->createProducer();

        $this->seedThreadMessagesAndReplies($crew, $producer);

        $time = Carbon::now()->subMinutes(30);

        $producer->threadsWithNewMessages()
                 ->flatMap(function($thread) use ($time, $producer) {
                    return $thread->messages()
                                  ->where('created_at', '>', $time)
                                  ->where('user_id', '!=', $producer->id)
                                  ->get()
                                  ->toArray();
                 })
                 ->flatmap(function($message) use($time) {
                    $this->assertArrayHas(
                        [
                            'thread_id' => 1,
                            'user_id' => 1,
                            'body' => 'Test Reply Message'
                        ], 
                        $message
                    );
                    
                    $this->assertLessThan($message['created_at'], $time);
                });
    }

    private function seedThreadMessagesAndReplies($crew, $producer)
    {
        $thread = factory(Thread::class)->create([
            'subject' => 'Thread Test Subject'
        ]);

        $thread->addParticipant(
            [
                'user_id' => $producer->id
            ]
        );

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
            'created_at' => Carbon::now()->subMinutes(31)
        ];

        $crew->messages()->create($replyFromCrew);
        $crew->messages()->create($oldReplyFromCrew);
    }
}