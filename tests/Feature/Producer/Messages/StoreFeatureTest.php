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
        // $this->withoutExceptionHandling();
        $crew = factory(User::class)->states('withCrewRole')->create();
        $project = factory(Project::class)->create([
            'user_id' => $crew->id,
        ]);
        $data = $this->getData();

        // when
        $response = $this
            ->actingAs($crew)
            ->postJson(route('producer.messages.store', $project), $data);

        // then
        $response->assertRedirect();
    }

    // validation tests
    /**
     * @test
     */
    public function fail_validation()
    {
        // $this->withoutExceptionHandling();
        // given
        $producer = factory(User::class)->states('withProducerRole')->create();
        $project = factory(Project::class)->create([
            'user_id' => $producer->id,
        ]);
        $data = [
            'subject' => '',
            'message' => '',
            'recipients' => '',
        ];

        // when
        $response = $this
            ->actingAs($producer)
            ->postJson(route('producer.messages.store', $project), $data);

        // then
        $response->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'subject' => ['The subject field is required.'],
                'message' => ['The message field is required.'],
                'recipients' => ['The recipients field is required.'],
            ]
        ]);
    }

    /**
     * @test
     */
    public function producer_cant_send_message_to_crews_who_has_not_applied()
    {
        // $this->withoutExceptionHandling();
        // given
        $producer = factory(User::class)->states('withProducerRole')->create();
        $randomCrews = factory(Crew::class, 3)->create();
        $project = factory(Project::class)->create([
            'user_id' => $producer->id,
        ]);
        $data = $this->getData();
        $data['recipients'] = $randomCrews->map(function ($crew) {
            return $crew->user->hash_id;
        });

        // when
        $response = $this
            ->actingAs($producer)
            ->postJson(route('producer.messages.store', $project), $data);

        // then
        $response->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'recipients' => ['The selected recipients is invalid.'],
            ]
        ]);
    }

    /**
     * @test
     */
    public function producer_can_send_message_to_a_crew_who_applied()
    {
        // $this->withoutExceptionHandling();
        // given
        $producer = factory(User::class)->states('withProducerRole')->create();
        $project = factory(Project::class)->create([
            'user_id' => $producer->id,
        ]);
        $crew = factory(Crew::class)->create();
        $project->contributors()->attach($crew);
        $data = $this->getData();
        $data['recipients'] = [
            $crew->user->hash_id,
        ];

        // when
        $response = $this
            ->actingAs($producer)
            ->postJson(route('producer.messages.store', $project), $data);

        // then
        $response->assertSee('Message sent.');
    }

    /**
     * @test
     */
    public function producer_can_send_message_to_multiple_crews_who_applied()
    {
        // $this->withExceptionHandling();
        // given
        $producer = factory(User::class)->states('withProducerRole')->create();
        $crews = factory(Crew::class, 3)->create();
        $project = factory(Project::class)->create([
            'user_id' => $producer->id,
        ]);
        $project->contributors()->attach($crews);
        $data = $this->getData();
        $data['recipients'] = $crews->map(function ($crew) {
            return $crew->user->hash_id;
        });

        // when
        $response = $this
            ->actingAs($producer)
            ->postJson(route('producer.messages.store', $project), $data);

        // then
        $response->assertSee('Messages sent.');
    }

    public function getData($overrides = [])
    {
        return [
            'subject' => 'Some subject',
            'message' => 'Some message',
        ];
    }
}
