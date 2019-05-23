<?php

namespace Tests\Unit\Actions\Crew;

use App\Actions\Crew\DeleteCrewPositionResume;
use App\Actions\Crew\StoreCrewPosition;
use App\Models\Crew;
use App\Models\CrewPosition;
use App\Models\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class DeleteCrewPositionResumeTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers App\Actions\Crew\DeleteCrewPosition::execute
     */
    public function execute()
    {
        // Given
        $user = $this->createUser();
        $crew = factory(Crew::class)->create([
            'user_id' => $user->id,
        ]);
        $position = factory(Position::class)->create();

        $data = [
            'position_id'       => $position->id,
            'resume'            => UploadedFile::fake()->create('resume.pdf'),
            'bio'               => 'This is the bio',
            'gear'              => 'This is the gear',
            'union_description' => 'Some union description',
            'reel_link'         => 'https://www.youtube.com/embed/G8S81CEBdNs',
        ];

        // Create an entry for crew_positions table
        app(StoreCrewPosition::class)->execute($crew, $position, $data);
        $crewPosition = CrewPosition::byCrewAndPosition($crew, $position)->first();

        // Then we delete the entry we just created
        app(DeleteCrewPositionResume::class)->execute($crew, $position);

        // Then assert entry is soft deleted
        $this->assertDatabaseMissing('crew_resumes', [
            'crew_id'           => $crew->id,
            'crew_position_id'  => $crewPosition->id,
        ]);
    }
}
