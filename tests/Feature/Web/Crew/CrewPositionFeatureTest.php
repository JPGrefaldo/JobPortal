<?php

namespace Tests\Feature\Web\Crew;

use App\Models\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class CrewPositionFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    public function setUp(): void
    {
        parent::setUp();

        Storage::fake('s3');

        $this->user = $this->createCrew();
    }

    /**
     * @test
     */
    public function store()
    {
        $this->withoutExceptionHandling();

        $position = factory(Position::class)->create();
        $data = $this->getStoreData();

        $this->actingAs($this->user)
            ->post(route('crew-position.store', $position), $data)
            ->assertSuccessful();
    }

    /**
     * @test
     */
    public function crew_position_bio_is_required()
    {
        $position = factory(Position::class)->create();
        $data1 = $this->getStoreData([
            'bio' => '',
        ]);

        $data2 = $this->getStoreData([
            'bio' => 'Less 10',
        ]);

        $this->actingAs($this->user)
            ->post(route('crew-position.store', $position), $data1)
            ->assertSessionHasErrors('bio');

        $this->actingAs($this->user)
            ->post(route('crew-position.store', $position), $data2)
            ->assertSessionHasErrors('bio');
    }

    /**
     * @test
     */
    public function crew_position_resume_is_valid_and_required()
    {
        $position = factory(Position::class)->create();
        $data1 = $this->getStoreData([
            'resume' => null,
        ]);

        $data2 = $this->getStoreData([
            'resume' => UploadedFile::fake()->create('resume.png'),
        ]);

        $this->actingAs($this->user)
            ->post(route('crew-position.store', $position), $data1)
            ->assertSessionHasErrors('resume');

        $this->actingAs($this->user)
            ->post(route('crew-position.store', $position), $data2)
            ->assertSessionHasErrors('resume');
    }

    /**
     * @test
     */
    public function crew_position_reel_link_is_valid()
    {
        $position = factory(Position::class)->create();
        $data = $this->getStoreData([
            'reel_link' => 'https://www.inavlid.com/invalid-link',
        ]);

        $this->actingAs($this->user)
            ->post(route('crew-position.store', $position), $data)
            ->assertSessionHasErrors('reel_link');
    }

    /**
     * @test
     */
    public function crew_position_gear_photo_must_be_an_image()
    {
        $position = factory(Position::class)->create();
        $data = $this->getStoreData([
            'gear_photos' => UploadedFile::fake()->create('file.pdf'),
        ]);

        $this->actingAs($this->user)
            ->post(route('crew-position.store', $position), $data)
            ->assertSessionHasErrors('gear_photos');
    }

    /**
     * @test
     */
    public function crew_position_union_is_required_on_position_that_has_union()
    {
        $position = factory(Position::class)->create([
            'has_union' => true,
        ]);

        $data = $this->getStoreData([
            'union_description' => UploadedFile::fake()->create('file.pdf'),
        ]);

        $this->actingAs($this->user)
            ->post(route('crew-position.store', $position), $data)
            ->assertSessionHasErrors('union_description');
    }

    /**
     * @test
     */
    public function crew_position_gear_is_required_on_position_that_has_gear()
    {
        $position = factory(Position::class)->create([
            'has_gear' => true,
        ]);

        $data = $this->getStoreData([
            'gear' => UploadedFile::fake()->create('resume.pdf'),
        ]);

        $this->actingAs($this->user)
            ->post(route('crew-position.store', $position), $data)
            ->assertSessionHasErrors('gear');
    }

    /**
     * @test
     */
    public function crew_can_leave_position()
    {
        $position = factory(Position::class)->create();

        $data = $this->getStoreData();

        $this->actingAs($this->user)
            ->post(route('crew-position.store', $position), $data)
            ->assertSuccessful()
            ->assertJsonFragment([
                'message' => 'success',
            ]);

        $this->delete(route('crew-position.delete', $position))
            ->assertSuccessful();
    }

    public function getStoreData($customData = [])
    {
        $data = [
            'resume'            => UploadedFile::fake()->create('resume.pdf'),
            'bio'               => 'This is the bio',
            'gear'              => 'This is the gear',
            'union_description' => 'Some union description',
            'reel_link'         => 'https://www.youtube.com/embed/G8S81CEBdNs',
        ];

        return $this->customizeData($data, $customData);
    }

    /**
     * @param $data
     * @param $customData
     *
     * @return mixed
     */
    protected function customizeData($data, $customData)
    {
        foreach ($customData as $key => $value) {
            Arr::set($data, $key, $value);
        }

        return $data;
    }
}
