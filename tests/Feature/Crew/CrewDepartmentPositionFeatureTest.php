<?php

namespace Tests\Feature\Crews;

use App\Models\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use Illuminate\Support\Facades\Storage;

class CrewDepartmentPositionTest extends TestCase
{
    use RefreshDatabase,
        SeedDatabaseAfterRefresh,
        WithFaker;

    /**
     * @test
     * @covers \App\Http\Controllers\Crew\CrewPositionController::store
     */
    public function apply_for()
    {
        // given
        // $this->withoutExceptionHandling();

        Storage::fake('s3');
        $crew     = $this->createCrew();
        $position = factory(Position::class)->create();

        $data = [
            'position_id'       => $position->id,
            'resume'            => UploadedFile::fake()->create('resume.pdf'),
            'bio'               => 'This is the bio',
            'gear'              => 'This is the gear',
            'union_description' => 'Some union description',
            'reel_link'         => 'https://www.youtube.com/embed/G8S81CEBdNs',
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

        Storage::fake('s3');

        $crew     = $this->createCrew();
        $position = factory(Position::class)->create();

        $data = [
            'position_id'       => $position->id,
            'bio'               => 'This is the bio',
            'gear'              => 'This is the gear',
            'union_description' => 'Some union description',
            'reel_link'         => 'https://www.youtube.com/embed/G8S81CEBdNs',
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

    /**
     * @test
     * @covers \App\Http\Controllers\Crew\CrewProfileController::store
     */
    public function create_position_requires_gear()
    {
        $crew     = $this->createCrew();
        $position = factory(Position::class)->create([
            'has_gear' => 1,
        ]);

        $data = [
            'position_id'       => $position->id,
            'bio'               => 'This is the bio',
            'resume'            => UploadedFile::fake()->create('resume.doc'),
            'union_description' => 'Some union description',
            'reel_link'         => 'http://www.youtube.com/embed/G8S81CEBdNs',
        ];

        $this->actingAs($crew)
            ->postJson(route('crew-position.store', $position), $data)
            ->assertJsonValidationErrors('gear');

        $this->assertDatabaseMissing('crew_position', [
            'crew_id'           => $crew->id,
            'details'           => $data['bio'],
            'union_description' => $data['union_description'],
        ]);

        $this->assertDatabaseMissing('crew_reels', [
            'crew_id' => $crew->id,
            'path'    => $data['reel_link'],
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Crew\CrewProfileController::store
     */
    public function create_position_dont_require_gear()
    {
        $crew     = $this->createCrew();
        $position = factory(Position::class)->create();

        $data = [
            'position_id'       => $position->id,
            'bio'               => 'This is the bio',
            'resume'            => UploadedFile::fake()->create('resume.doc'),
            'union_description' => 'Some union description',
            'gear'              => 'This is the gear',
            'reel_link'         => "http://www.youtube.com/embed/G8S81CEBdNs",
        ];

        $this->actingAs($crew)
            ->postJson(route('crew-position.store', $position), $data)
            ->assertSessionDoesntHaveErrors();

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
        ]);
    }
}
