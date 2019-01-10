<?php

namespace Tests\Unit;

use App\Actions\User\FlagMessage;
use App\Mail\MessageFlagged;
use Cmgmyr\Messenger\Models\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class FlagMessageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @cover \App\Actions\User\FlagMessage::execute
     */
    public function execute()
    {
        Mail::fake();

        // given
        $message = factory(Message::class)->create();
        $this->assertNull($message->flagged_at);

        // when
        app(FlagMessage::class)->execute($message);

        // then
        $this->assertNotNull($message->fresh()->flagged_at);
        Mail::assertSent(
            MessageFlagged::class,
            function ($mail) use ($message) {
                return
                    $mail->message->id === $message->id &&
                    $mail->hasTo('admin@admin.com');
            }
        );
    }
}
