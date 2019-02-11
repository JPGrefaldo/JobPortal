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
     * @covers \App\Http\Controllers\Crew\CrewPositionController
     */
    public function applyFor()
    {
        $this->withoutExceptionHandling();

        $user = $this->createCrew();
        $crew = $user->crew;
        $position = factory(Position::class)->create();
        $reels = factory(CrewReel::class)->create();
        $gears = factory(CrewGear::class)->create();


        $crew->reels()->attach($reels,[
            'crew_id' =>$crew->id,
            'url' =>'https:://www.youtube.com',
            'general'=> false,
            'crew_position_id' =>$position->id
        ]);

        $crew->gears()->attach($gears,[
            'crew_id' =>$crew->id,
            'description' => 'This is the gear description',
            'crew_position_id' =>$position->id
        ]);

        $data = [
            'position_id' => $position->id,
            'bio' => 'This is the bio',
            'gear' => 'This is the gear',
            'reel_link' => 'This is the reel link',
        ];

        $response = $this->actingAs($user)
            ->postJson(route('crew-position.applyFor', $position->id), $data);

        $response->assertSuccessful();
    }

}
