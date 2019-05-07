<?php

namespace Tests\Feature\API\Producer;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use App\Models\MessageMacro;
use Illuminate\Http\Response;

class MessageMacroFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    protected const META = [
        'Accept' => 'application/json',
    ];

    /**
     * @test
     * @covers \App\Http\Controllers\API\Producer\MessageMacrosController::index
     */
    public function can_fetch_message_macros()
    {
        $user = $this->createProducer();

        factory(MessageMacro::class, 5)->create([
            'user_id' => $user->id
        ]);

        $this->actingAs($user, 'api')
            ->get(route('producer.message.macros'))
            ->assertSee('Sucessfully fetched all message macros')
            ->assertSuccessful();
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\Producer\MessageMacrosController::store
     */
    public function can_create_message_macros()
    {
        $user = $this->createProducer();

        $data = ['message' => 'Some message to save'];

        $this->actingAs($user, 'api')
            ->post(
                route('producer.message.macros'),
                $data,
                self::META
            )
            ->assertSee('Sucessfully save message template')
            ->assertStatus(Response::HTTP_CREATED);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\Producer\MessageMacrosController::store
     */
    public function cannot_crate_projects_the_unauthorized_role()
    {
        $user = $this->createCrew();
        $data = [];

        $this->actingAs($user, 'api')
            ->post(
                route('producer.message.macros'),
                $data,
                self::META
            )
            ->assertSee('User does not have the right roles.')
            ->assertForbidden();
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\Producer\MessageMacrosController::store
     */
    public function cannot_create_a_macro_when_message_field_is_empty()
    {
        $user = $this->createProducer();

        $data = ['message' => ''];

        $this->actingAs($user, 'api')
            ->post(
                route('producer.message.macros'),
                $data,
                self::META
            )
            ->assertSee('The given data was invalid.')
            ->assertSee('The message field is required.')
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\Producer\MessageMacrosController::store
     */
    public function cannot_create_a_message_macro_when_data_is_invalid()
    {
        $user = $this->createProducer();

        $data = ['message' => false];

        $this->actingAs($user, 'api')
            ->post(
                route('producer.message.macros'),
                $data,
                self::META
            )
            ->assertSee('The given data was invalid.')
            ->assertSee('The message must be a string.')
            ->assertSee('The message must be at least 6 characters.')
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}