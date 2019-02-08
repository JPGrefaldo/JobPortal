<?php

namespace Tests\Feature;

use App\Models\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreCrewPositionFeatureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @covers App\Http\Controllers\Crew\CrewPositionController::store
     */
    public function store()
    {
        // given
        $user = $this->createCrew();
        $crew = $user->crew;
        $position = factory(Position::class)->create();

        $data = [
            'position_id' => $position->id,
            'bio' => 'This is the bio',
            'gear' => 'This is the gear',
            'reel_link' => 'This is the reel link',
        ];

        // when
        $response = $this->actingAs($user)
            ->postJson(route('crew-position.store'), $data);


        // then
        $response->assertSuccessful();
    }
}
