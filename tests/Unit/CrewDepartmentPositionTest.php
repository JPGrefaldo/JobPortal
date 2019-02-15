<?php

namespace Tests\Unit;

use App\Models\Crew;
use App\Models\CrewPosition;
use App\Models\Position;
use App\Models\User;
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
     * @covers \App\Http\Controllers\Crew\CrewPositioncontroller::applyFor
     */
    public function apply_for()
    {
       $this->withoutExceptionHandling();

        $user = $this->createCrew();
        $crew = factory(Crew::class)->create([
            'user_id' => $user->id,
        ]);
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
