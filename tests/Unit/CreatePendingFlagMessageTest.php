<?php

namespace Tests\Unit;

use App\Actions\User\CreatePendingFlagMessage;
use App\Mail\PendingMessageFlagged;
use Cmgmyr\Messenger\Models\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class CreatePendingFlagMessageTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     * @cover \App\Http\Controller\PendingMessage\Controller::store
     */
    public function crewPendingFlagProducer()
    {
        Mail::fake();

        // given
        $message = factory(Message::class)->create();

        $data = [
            'message_id' => $message->id,
            'reason' => 'Profanity',
        ];

        // when
        app(CreatePendingFlagMessage::class)->execute($data);

        // then
        // pending flag is stored
        $this->assertDatabaseHas('pending_flag_messages', [
            'message_id' => $message->id,
            'reason' => 'Profanity',
            'approved_at' => null,
            'disapproved_at' => null,
        ]);

        Mail::assertSent(
            PendingMessageFlagged::class,
            function ($mail) use ($message) {
                return
                    $mail->message->id === $message->id &&
                    $mail->hasTo('admin@admin.com');
            }
        );
    }
}
