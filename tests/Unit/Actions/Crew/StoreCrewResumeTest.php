<?php

namespace Tests\Unit\Actions\Crew;

use Illuminate\Support\Arr;
use App\Actions\Crew\StoreCrewResume;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Support\CreatesCrewModel;
use Tests\Support\Data\SocialLinkTypeID;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class StoreCrewResumeTest extends TestCase
{
    use RefreshDatabase,
        SeedDatabaseAfterRefresh,
        CreatesCrewModel;

    /**
     * @test
     * @covers \App\Actions\Crew\StoreCrewResume::execute
     */
    public function execute()
    {
        Storage::fake('s3');

        $models = $this->createCompleteCrew();

        $oldResumePath = $models['crew']->resumes()->where('general', true)->first()->path;

        Storage::disk('s3')->assertExists($oldResumePath);

        $data = $this->getCreateCrewData();

        app(StoreCrewResume::class)->execute($models['crew'], $data);

        $this->assertDatabaseHas('crew_resumes', [
            'crew_id'          => $models['crew']->id,
            'path'             => $models['user']->hash_id . '/resumes/' . $data['resume']->hashName(),
            'general'          => true,
            'crew_position_id' => null,
        ]);

        $resume = $models['crew']->refresh()->resumes->where('general', true)->first();
        Storage::disk('s3')->assertMissing($oldResumePath);
        Storage::disk('s3')->assertExists($resume->path);
    }

    /**
     * @test
     * @covers \App\Actions\Crew\StoreCrewResume::execute
     */
    public function execute_new_user()
    {
        Storage::fake('s3');

        $models = $this->createCompleteCrew([
            'reel' => [
                'path' => '',
            ],
        ]);

        $resume = $models['crew']->refresh()->resumes->where('general', true)->first();

        $data = [
            'resume'  => UploadedFile::fake()->create('resume.pdf'),
        ];

        app(StoreCrewResume::class)->execute($models['crew'], $data);

        $this->assertDatabaseHas('crew_resumes', [
            'crew_id'          => $models['crew']->id,
            'path'             => $models['user']->hash_id . '/resumes/' . $data['resume']->hashName(),
            'general'          => true,
            'crew_position_id' => null,
        ]);

        $resume = $models['crew']->refresh()->resumes->where('general', true)->first();
        Storage::disk('s3')->assertExists($resume->path);
    }
}
