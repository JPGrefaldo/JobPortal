<?php

namespace Tests\Feature;

use App\Models\Crew;
use App\Models\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class StoreCrewPositionFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers App\Http\Controllers\Crew\CrewPositionController::store
     */
    public function store()
    {
        // $this->withoutExceptionHandling();

        // given
        $user = $this->createCrew();
        $crew = factory(Crew::class)->create([
            'user_id' => $user->id,
        ]);
        $position = factory(Position::class)->create();

        $data = [
            'position_id' => $position->id,
            'bio' => 'This is the bio',
            'gear' => 'This is the gear',
            'reel_link' => 'This is the reel link',
            'union_description' => 'This is the union description',
        ];

        // when
        $response = $this->actingAs($user)
            ->postJson(route('crew-position.store', $position->id), $data);


        // then
        $response->assertSuccessful();
    }
}
