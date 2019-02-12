<?php

namespace Tests\Unit;

use App\Models\Crew;
use App\Models\CrewPosition;
use App\Models\Position;
use App\Models\CrewGear;
use App\Models\CrewReel;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;

class CrewDepartmentPositionTest extends TestCase
{
    use RefreshDatabase,
        SeedDatabaseAfterRefresh,
        WithFaker;
    /**
     * @test
     * @covers \App\Models\CrewPosition
     */

    public function apply_for()
    {
        $this->withoutExceptionHandling();

        $user = $this->createCrew();
        $crew = $user->crew;
        $position = factory(Position::class)->create();

        $data = [
            'position_id' => $position->id,
            'bio' => 'This is the bio',
            'gear' => 'This is the gear',
            'reel_link' => 'This is the reel link',
        ];

        $response = $this->actingAs($user)
            ->postJson(route('crew-position.store',$position->id), $data);


        $response->assertSuccessful();
    }

}
