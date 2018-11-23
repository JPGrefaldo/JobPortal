<?php

namespace Tests\Feature\Producer\Messages;

use App\Models\User;
use Cmgmyr\Messenger\Models\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class UpdateFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;
    /**
     * @test
     */
    public function producer_can_flag_a_message()
    {
        // given
        $producer = factory(User::class)->states('withProducerRole')->create();
        $message = factory(Message::class)->create();

        // when
        $request = $this
            ->actingAs($producer)
            ->putJson(route('producer.messages.update', $message));

        // then
        $request->assertSee('Message Flagged');
    }
}
