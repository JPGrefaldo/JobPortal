<?php

namespace Tests\Feature\Producer\Messages;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class StoreFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     */
    public function authorization()
    {
        $this->withoutExceptionHandling();
        $crew = factory(User::class)->states('withCrewRole')->create();
        $data = $this->getData();

        // when
        $response = $this
            ->actingAs($crew)
            ->postJson(route('producer.messages.store'), $data);

        // then
        $response->assertRedirect();

        // given
        $producer = factory(User::class)->states('withProducerRole')->create();
        $data = $this->getData();

        // when
        $response = $this
            ->actingAs($producer)
            ->postJson(route('producer.messages.store'), $data);

        // then
        $response->assertSuccessful();
    }

    // "// validation\r",
    /**
     * @test
     */
    public function validation()
    {
        // given
        $producer = factory(User::class)->states('withProducerRole')->create();
        $data = [
            'subject' => '',
            'message' => '',
            'recipients' => 1,
        ];

        // when
        $response = $this
            ->actingAs($producer)
            ->postJson(route('producer.messages.store'));

        // then
        $response->assertSessionHasErrors();
    }
    // "// general logic\r",

    public function getData($overrides = [])
    {
        return [
            'subject' => 'Some subject',
            'message' => 'Some message',
        ];
    }
}
