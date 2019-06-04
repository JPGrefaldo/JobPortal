<?php

namespace Tests\Feature\Web\Producer;

use App\Models\Crew;
use App\Models\Project;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class CrewMessagingFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\MessagesController::store
     */
    public function can_send_a_message_to_multiple_crews_who_applied()
    {
        $this->send_messages();
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\MessagesController::store
     */
    public function only_producers_can_message()
    {
        $crew = $this->createCrew();
        $project = factory(Project::class)->create();
        $data = $this->get_data();

        $this->actingAs($crew, 'api')
            ->postJson(route('producer.message.crew.store', $project), $data)
            ->assertForbidden();
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\MessageController::store
     */
    public function cant_send_message_if_required_fields_are_empty()
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

        $this->actingAs($producer, 'api')
            ->postJson(route('producer.message.crew.store', $project), $data)
            ->assertSee('The given data was invalid.')
            ->assertSee('The message field is required.')
            ->assertSee('The recipients field is required.')
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\MessageController::store
     */
    public function crew_should_receive_the_message_individually()
    {
        $this->send_messages();

        $threads = Thread::all();

        $this->assertCount(3, $threads);

        $sentTimes = 0;
        foreach ($threads as $thread) {
            $record = $thread->participantsUserIds()[0];
            
            $recipient = User::where('hash_id', $record)->get();
            $this->assertCount(1, $recipient);

            foreach ($recipient as $user) {
                $thread->userUnreadMessages($user->hash_id)->map(function ($message) {
                    $this->assertEquals('Some message', $message->body);
                });
            }
            ++$sentTimes;
        }

        $this->assertEquals(3, $sentTimes);
    }

    private function get_data()
    {
        return [
            'subject' => 'Some subject',
            'message' => 'Some message',
        ];
    }

    private function send_messages()
    {
        $producer = $this->createProducer();
        $crews    = factory(Crew::class, 3)->create();

        $project  = factory(Project::class)->create([
            'user_id' => $producer->id,
        ]);

        $project->contributors()->attach($crews);

        $data = $this->get_data();
        $data['recipients'] = $crews->map(function ($crew) {
            return $crew->user->id;
        });

        $this->actingAs($producer, 'api')
            ->postJson(route('producer.message.crew.store', $project), $data)
            ->assertSee("Successfully save the crews' message");
    }
}
