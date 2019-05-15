<?php

namespace Tests\Feature\Crew;

use App\Models\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use Illuminate\Support\Facades\Storage;

class StoreCrewPositionFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers App\Http\Controllers\Crew\CrewPositionController::store
     */
    public function store()
    {
        //$this->withoutExceptionHandling();
        Storage::fake('s3');

        // given
        $user = $this->createCrew();
        $position = factory(Position::class)->create();

        $data = [
            'position_id'       => $position->id,
            'bio'               => 'This is the bio',
            'gear'              => 'This is the gear',
            'reel_link'         => 'http://www.youtube.com/embed/G8S81CEBdNs',
            'resume'            => UploadedFile::fake()->create('test.pdf'),
            'union_description' => '',
        ];

        // when
        $response = $this->actingAs($user)
            ->postJson(route('crew-position.store', $position->id), $data);

        // then
        $response->assertSuccessful();
    }
}