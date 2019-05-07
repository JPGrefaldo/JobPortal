<?php

namespace Tests\Feature\Crews;

use App\Models\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
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
        // given
        $this->withoutExceptionHandling();

        $crew     = $this->createCrew();
        $position = factory(Position::class)->create();

        $data = [
            'position_id'       => $position->id,
            'resume'            => UploadedFile::fake()->create('resume.pdf'),
            'bio'               => 'This is the bio',
            'gear'              => 'This is the gear',
            'union_description' => 'Some union description',
            'reel_link'         => 'http://www.youtube.com/embed/G8S81CEBdNs',
        ];

        $response = $this->actingAs($crew)
            ->postJson(route('crew-position.store', $position), $data);
            
        $response->assertSuccessful();

        $this->assertDatabaseHas('crew_position', [
            'crew_id'           => $crew->id,
            'details'           => $data['bio'],
            'union_description' => $data['union_description'],
        ]);

        $this->assertDatabaseHas('crew_gears', [
            'crew_id'     => $crew->id,
            'description' => $data['gear'],
        ]);

        $this->assertDatabaseHas('crew_reels', [
            'crew_id' => $crew->id,
            'path'    => $data['reel_link'],
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Crew\CrewPositionController::applyFor
    */
    public function cannot_apply_without_general_resume()
    {
        //$this->withoutExceptionHandling();
        $crew     = $this->createCrew();
        $position = factory(Position::class)->create();

        $data = [
            'position_id'       => $position->id,
            'bio'               => 'This is the bio',
            'gear'              => 'This is the gear',
            'union_description' => 'Some union description',
            'reel_link'         => 'http://www.youtube.com/embed/G8S81CEBdNs',
        ];

        $response = $this->actingAs($crew)
           ->postJson(route('crew-position.store', $position), $data);

        $response->assertJsonValidationErrors('resume');

        $this->assertDatabaseMissing('crew_position', [
            'crew_id'           => $crew->id,
            'details'           => $data['bio'],
            'union_description' => $data['union_description'],
        ]);

        $this->assertDatabaseMissing('crew_gears', [
            'crew_id'     => $crew->id,
            'description' => $data['gear'],
        ]);

        $this->assertDatabaseMissing('crew_reels', [
            'crew_id' => $crew->id,
            'path'    => $data['reel_link'],
        ]);
    }
}
