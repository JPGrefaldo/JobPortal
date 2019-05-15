<?php

namespace Tests\Feature\Producer\Messages;

use App\Models\Crew;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

// TODO: restructure
class StoreFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\MessageController::store
     */
    public function only_producers_can_message()
    {
        // $this->withoutExceptionHandling();
        $crew = $this->createCrew();
        $project = factory(Project::class)->create([
            'user_id' => $crew->id,
        ]);
        $data = $this->getData();

        $response = $this
            ->actingAs($crew)
            ->postJson(route('producer.messages.store', $project), $data);

        $response->assertForbidden();
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\MessageController::store
     */
    public function producer_must_own_project()
    {
        $producer = $this->createProducer();
        $project = factory(Project::class)->create();

        $response = $this
            ->actingAs($producer)
            ->postJson(route('producer.messages.store', $project));

        $response->assertStatus(403);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\MessageController::store
     */
    public function all_fields_are_required()
    {
        // $this->withoutExceptionHandling();
        $producer = $this->createProducer();
        $project = factory(Project::class)->create([
            'user_id' => $producer->id,
        ]);
        $data = [
            'subject'    => '',
            'message'    => '',
            'recipients' => '',
        ];

        $response = $this
            ->actingAs($producer)
            ->postJson(route('producer.messages.store', $project), $data);

        $response->assertJson([
            'message' => 'The given data was invalid.',
            'errors'  => [
                'message'    => ['The message field is required.'],
                'recipients' => ['The recipients field is required.'],
            ],
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\MessageController::store
     */
    public function producer_cant_send_message_to_crews_who_has_not_applied()
    {
        // $this->withoutExceptionHandling();
        $producer = $this->createProducer();
        $randomCrews = factory(Crew::class, 3)->create();
        $project = factory(Project::class)->create([
            'user_id' => $producer->id,
        ]);
        $data = $this->getData();
        $data['recipients'] = $randomCrews->map(function ($crew) {
            return $crew->user->hash_id;
        });

        $response = $this
            ->actingAs($producer)
            ->postJson(route('producer.messages.store', $project), $data);

        $response->assertJson([
            'message' => 'The given data was invalid.',
            'errors'  => [
                'recipients' => ['The selected recipients is invalid.'],
            ],
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\MessageController::store
     */
    public function producer_can_send_message_to_multiple_crews_who_applied()
    {
        // $this->withExceptionHandling();
        $producer = $this->createProducer();
        $crews = factory(Crew::class, 3)->create();
        $project = factory(Project::class)->create([
            'user_id' => $producer->id,
        ]);
        $project->contributors()->attach($crews);
        $data = $this->getData();
        $data['recipients'] = $crews->map(function ($crew) {
            return $crew->user->hash_id;
        });

        $response = $this
            ->actingAs($producer)
            ->postJson(route('producer.messages.store', $project), $data);

        $response->assertSee('Messages sent.');
    }

    // TODO: check number of emails sent

    protected function getData($overrides = [])
    {
        return [
            'message' => 'Some message',
        ];
    }
}
