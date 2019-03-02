<?php

namespace Tests\Unit;

use App\Models\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class CrewDepartmentPositionTest extends TestCase
{
    use RefreshDatabase,
        SeedDatabaseAfterRefresh,
        WithFaker;

    /**
     * @test
     * @covers \App\Http\Controllers\Crew\CrewPositionController::applyFor
     */
    public function apply_for()
    {
//        $this->withoutExceptionHandling();

        $user = $this->createCrew();
        $position = factory(Position::class)->create();

        $data = [
            'position_id' => $position->id,
            'bio' => 'This is the bio',
            'gear' => 'This is the gear',
            'union_description' => 'Some union description',
            'reel_link' => 'This is the reel link',
        ];

        $response = $this->actingAs($user)
            ->postJson(route('crew-position.store', $position), $data);

        $response->assertSuccessful();
    }
}
