<?php

namespace Tests\Unit\Notifications;

use App\Notifications\UnreadMessagesInThread;
use Carbon\Carbon;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class UnreadMessagesInThreadTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

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
}
