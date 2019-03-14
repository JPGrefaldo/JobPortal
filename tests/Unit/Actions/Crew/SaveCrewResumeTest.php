<?php

namespace Tests\Unit\Actions\Crew;

use App\Actions\Crew\SaveCrewResume;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class SaveCrewResumeTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;
    /**
     * @test
     * @covers \App\Actions\Crew\SaveCrewResume::execute
     */
    public function execute()
    {
        // given
        Storage::fake('s3');

        $user = $this->createCrew();
        $data = [
            'resume'  => UploadedFile::fake()->create('resume.pdf'),
        ];

        // when
        app(SaveCrewResume::class)->execute($user->crew, $data);

        // then
        $this->assertDatabaseHas('crew_resumes', [
            'crew_id' => $user->crew->id,
            'path' => $user->hash_id . '/resumes/' . $data['resume']->hashName(),
            'general' => true,
            'crew_position_id' => null,
        ]);

        $resume = $user->crew->resumes->where('general', true)->first();
        Storage::disk('s3')->assertExists($resume->path);
    }
}
