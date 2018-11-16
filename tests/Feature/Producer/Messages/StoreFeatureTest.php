<?php

namespace Tests\Feature\Producer\Messages;

use App\Models\Crew;
use App\Models\Project;
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
    public function fail_authorization()
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
    }

    /**
     * @test
     */
    public function pass_authorization()
    {
        $this->withoutExceptionHandling();
        // given
        $producer = factory(User::class)->states('withProducerRole')->create();
        $project = factory(Project::class)->create([
            'user_id' => $producer->id,
        ]);
        factory(Crew::class, 3)->create();
        $data = $this->getData();
        $data['recipients'] = [
            Crew::find(1)->user->hash_id,
            Crew::find(2)->user->hash_id,
            Crew::find(3)->user->hash_id,
        ];

        // when
        $response = $this
            ->actingAs($producer)
            ->postJson(route('producer.messages.store', $project), $data);

        // then
        $response->assertDontSee('You are not a producer.');
        $response->assertDontSee('The project does not exist.');
        $response->assertDontSee('You have to select a recipient.');
        $response->assertSuccessful();
        dump($response->getContent());
    }

    // "// validation\r",
    /**
     * @test
     */
    public function failValidation()
    {
        // $this->withoutExceptionHandling();
        // given
        $producer = factory(User::class)->states('withProducerRole')->create();
        $data = [
            'subject' => '',
            'message' => '',
            'recipients' => '',
        ];

        // when
        $response = $this
            ->actingAs($producer)
            ->postJson(route('producer.messages.store'), $data);

        // then
        $response->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'subject' => ['The subject field is required.'],
                'message' => ['The message field is required.'],
                'recipients' => ['The selected recipients is invalid.'],
            ]
        ]);
    }

    /**
     * @test
     */
    public function passValidation()
    {
        $this->withoutExceptionHandling();
        // given
        $producer = factory(User::class)->states('withProducerRole')->create();
        factory(Crew::class, 3)->create();
        $data = $this->getData();
        $data['recipients'] = [
            Crew::find(1)->user->hash_id,
            Crew::find(2)->user->hash_id,
            Crew::find(3)->user->hash_id,
        ];

        // when
        $response = $this
            ->actingAs($producer)
            ->postJson(route('producer.messages.store'), $data);

        // then
        $response->assertSuccessful();
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
