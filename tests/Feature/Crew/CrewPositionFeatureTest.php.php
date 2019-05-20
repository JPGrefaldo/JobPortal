<?php

namespace Tests\Feature\Crew;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\Support\SeedDatabaseAfterRefresh;
use Illuminate\Support\Arr;
use Illuminate\Http\UploadedFile;
use App\Models\Position;

class CrewPositionFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh, WithFaker;

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
        $data = $this->getStoreData();

        $this->actingAs($this->user)
            ->post(route('crew-position.store', 1), $data)
            ->assertSuccessful();
    }

    /**
     * @test
     */
    public function crew_position_bio_is_required()
    {
        $data1 = $this->getStoreData([
            'bio' => '',
        ]);

        $data2 = $this->getStoreData([
            'bio' => 'Less 10',
        ]);

        $this->actingAs($this->user)
            ->post(route('crew-position.store', 1), $data1)
            ->assertSessionHasErrors('bio');

        $this->actingAs($this->user)
            ->post(route('crew-position.store', 1), $data2)
            ->assertSessionHasErrors('bio');
    }

    /**
     * @test
     */
    public function crew_position_resume_is_valid_and_required()
    {
        $data1 = $this->getStoreData([
            'resume' => null,
        ]);

        $data2 = $this->getStoreData([
            'resume' => UploadedFile::fake()->create('resume.png'),
        ]);

        $this->actingAs($this->user)
            ->post(route('crew-position.store', 1), $data1)
            ->assertSessionHasErrors('resume');

        $this->actingAs($this->user)
            ->post(route('crew-position.store', 1), $data2)
            ->assertSessionHasErrors('resume');
    }

    /**
     * @test
     */
    public function crew_position_reel_link_is_valid()
    {
        $data = $this->getStoreData([
            'reel_link' => 'https://www.inavlid.com/invalid-link',
        ]);

        $this->actingAs($this->user)
            ->post(route('crew-position.store', 1), $data)
            ->assertSessionHasErrors('reel_link');
    }

    /**
     * @test
     */
    public function crew_position_gear_photo_must_be_an_image()
    {
        $data = $this->getStoreData([
            'gear_photos' => UploadedFile::fake()->create('file.pdf'),
        ]);

        $this->actingAs($this->user)
            ->post(route('crew-position.store', 1), $data)
            ->assertSessionHasErrors('gear_photos');
    }

    /**
     * @test
     */
    public function crew_position_union_is_required_on_position_that_has_union()
    {
        $position = factory(Position::class)->create([
            'has_union' => true
        ]);

        $data = $this->getStoreData([
            'union_description' => UploadedFile::fake()->create('file.pdf'),
        ]);

        $this->actingAs($this->user)
            ->post(route('crew-position.store', $position->id), $data)
            ->assertSessionHasErrors('union_description');
    }

    /**
     * @test
     */
    public function crew_position_gear_is_required_on_position_that_has_gear()
    {
        $position = factory(Position::class)->create([
            'has_gear' => true
        ]);

        $data = $this->getStoreData([
            'gear' => UploadedFile::fake()->create('resume.pdf'),
        ]);

        $this->actingAs($this->user)
            ->post(route('crew-position.store', $position->id), $data)
            ->assertSessionHasErrors('gear');
    }

    public function getStoreData($customData = [])
    { 
        $position = factory(Position::class)->create();

        $data = [
            'position_id'       => $position->id,
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
