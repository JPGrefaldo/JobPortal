<?php

namespace Tests\Feature\API\Producer;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use App\Models\MessageTemplate;
use Illuminate\Http\Response;

class MessageTemplateFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Http\Controllers\API\Producer\MessageTemplatesController::index
     */
    public function can_fetch_message_templates()
    {
        $this->withoutExceptionHandling();
        
        $user = $this->createProducer();

        factory(MessageTemplate::class, 5)->create([
            'user_id' => $user->id
        ]);

        $this->actingAs($user, 'api')
            ->get(route('producer.messages.templates'))
            ->assertSee('Sucessfully fetched all message templates')
            ->assertSuccessful();
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\Producer\MessageTemplatesController::store
     */
    public function can_create_message_templates()
    {
        $user = $this->createProducer();

        $data = ['message' => 'Some message to save'];

        $this->actingAs($user, 'api')
            ->postJson(
                route('producer.messages.templates'),
                $data
            )
            ->assertSee('Sucessfully save message template')
            ->assertStatus(Response::HTTP_CREATED);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\Producer\MessageTemplatesController::store
     */
    public function cannot_create_the_unauthorized_role()
    {
        $user = $this->createCrew();
        $data = [];

        $this->actingAs($user, 'api')
            ->postJson(
                route('producer.messages.templates'),
                $data
            )
            ->assertSee('User does not have the right roles.')
            ->assertForbidden();
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\Producer\MessageTemplatesController::store
     */
    public function cannot_create_a_template_when_message_field_is_empty()
    {
        $user = $this->createProducer();

        $data = ['message' => ''];

        $this->actingAs($user, 'api')
            ->postJson(
                route('producer.messages.templates'),
                $data
            )
            ->assertSee('The given data was invalid.')
            ->assertSee('The message field is required.')
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\Producer\MessageTemplatesController::store
     */
    public function cannot_create_a_message_template_when_data_is_invalid()
    {
        $user = $this->createProducer();

        $data = ['message' => false];

        $this->actingAs($user, 'api')
            ->postJson(
                route('producer.messages.templates'),
                $data
            )
            ->assertSee('The given data was invalid.')
            ->assertSee('The message must be a string.')
            ->assertSee('The message must be at least 6 characters.')
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}