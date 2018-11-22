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
    }

    // "// validation\r",
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
                'recipients' => ['The selected recipients is invalid.'],
            ]
        ]);
    }

    /**
     * @test
     */
    public function pass_validation()
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
        $response->assertSuccessful();
    }
    // "// general logic\r",    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     */
    public function producer_can_send_message_to_a_crew_who_applied()
    {
        $this->withoutExceptionHandling();
        // given
        $producer = factory(User::class)->states('withProducerRole')->create();
        $project = factory(Project::class)->create([
            'user_id' => $producer->id,
            'title' => 'Some project',
            'production_name' => 'Some production name',
        ]);
        $crew = factory(Crew::class)->create();
        $project->contributors()->attach($crew);
        $this->assertDatabaseHas('crew_project', [
            'crew_id' => $crew->id,
            'project_id' => $project->id
        ]);
        $this->assertCount(1, $crew->projects);
        $data = [
            'subject' => 'Some subject',
            'message' => 'Some message',
            'recipients' => [
                $crew->user->hash_id,
            ]
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
    public function producer_cant_send_message_to_crew_who_has_not_applied()
    {
        // $this->withoutExceptionHandling();
        // given
        $producer = factory(User::class)->states('withProducerRole')->create();
        $randomCrew = factory(User::class)->states('withCrewRole')->create();
        $project = factory(Project::class)->create();
        $data = [
            'subject' => 'Some subject',
            'message' => 'Some message',
            'recipients' => [
                $randomCrew->id,
            ]
        ];

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
    public function producer_can_send_message_to_multiple_crews_who_applied()
    {
        // given
        $producer = factory(User::class)->states('withProducerRole')->create();
        $crews = factory(Crew::class, 3)->create();
        $project = factory(Project::class)->create([
            'user_id' => $producer->id,
        ]);
        dump(Crew::all()->toArray());
        $project->contributors()->attach($crews);
        $data = [
            'subject' => 'Some subject',
            'message' => 'Some message',
            'recipients' => [
                Crew::find(1)->user->hash_id,
                Crew::find(2)->user->hash_id,
                Crew::find(3)->user->hash_id,
            ]
        ];

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
