<?php

namespace Tests\Unit\Actions\Crew;

use App\Actions\Crew\EditCrew;
use App\Actions\Crew\StoreCrew;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Tests\Support\CreatesCrewModel;
use Tests\Support\Data\SocialLinkTypeID;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class EditCrewTest extends TestCase
{
    use RefreshDatabase,
        SeedDatabaseAfterRefresh,
        CreatesCrewModel;

    /**
     * @test
     * @covers \App\Actions\Crew\EditCrew::execute
     */
    public function execute()
    {
        Storage::fake('s3');

        $models = $this->createCompleteCrew();
        $data = $this->getUpdateCrewData();

        app(EditCrew::class)->execute($models['crew'], $data);

        $this->assertDatabaseHas('crews', [
            'user_id'    => $models['user']->id,
            'bio'        => 'updated bio',
        ]);
    }
}
