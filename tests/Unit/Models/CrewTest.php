<?php

namespace Tests\Unit\Models;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use App\Models\Crew;
use App\Models\CrewGear;
use App\Models\CrewPosition;
use App\Models\CrewReel;
use App\Models\CrewResume;
use App\Models\CrewSocial;
use App\Models\Position;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class CrewTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    protected $user;
    protected $crew;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createUser();
        $this->crew = factory(Crew::class)->create(['user_id' => $this->user->id]);
    }

    /**
     * @test
     * @covers \App\Models\Crew::user
     */
    public function user()
    {
        $this->assertEquals(
            $this->user->email,
            $this->crew->user->email
        );
    }

    /**
     * @test
     * @covers \App\Models\Crew::positions
     */
    public function positions()
    {
        factory(Position::class, 10)->create();
        $first  = rand(1, 10);
        $second = rand(1, 10);

        factory(CrewPosition::class)->create([
            'crew_id'     => $this->crew->id,
            'position_id' => $first,
        ]);
        factory(CrewPosition::class)->create([
            'crew_id'     => $this->crew->id,
            'position_id' => $second,
        ]);

        $this->assertCount(2, $this->crew->positions);
        $this->assertArrayHas([$first, $second], $this->crew->positions->pluck('id'));
    }

    /**
     * @test
     * @covers \App\Models\Crew::reels
     */
    public function reels()
    {
        // when
        $this->crew->reels()->saveMany(factory(CrewReel::class, 3)->create());

        // then
        $this->assertCount(3, $this->crew->reels);
    }

    /**
     * @test
     * @covers \App\Models\Crew::hasGeneralReel
     */
    public function hasGeneralReel()
    {
        // given
        $this->assertFalse($this->crew->hasGeneralReel());

        // when
        factory(CrewReel::class)->create([
            'crew_id' => $this->crew->id,
            'general' => true,
        ]);

        // then
        $this->assertTrue($this->crew->hasGeneralReel());
    }

    /**
     * @test
     * @covers \App\Models\Crew::getGeneralReelLink
    */
    public function getGeneralReelLink()
    {
        //given
        $this->assertNull($this->crew->getGeneralReelLink());

        // when
        factory(CrewReel::class)->create([
            'crew_id' => $this->crew->id,
            'path'    => 'https://www.youtube.com/embed/WI5AF1DCQlc',
            'general' => true,
        ]);

        //then
        $this->assertEquals('https://www.youtube.com/embed/WI5AF1DCQlc', $this->crew->getGeneralReelLink());
    }

    /**
     * @test
     * @covers \App\Models\Crew::resumes
     */
    public function resumes()
    {
        // when
        $this->crew->resumes()->saveMany(factory(CrewResume::class, 3)->create());

        // then
        $this->assertCount(3, $this->crew->resumes);
    }

    /**
     * @test
     * @covers \App\Models\Crew::gears
     */
    public function gears()
    {
        // when
        $this->crew->gears()->saveMany(factory(CrewGear::class, 3)->create());

        // then
        $this->assertCount(3, $this->crew->gears);
    }

    /**
     * @test
     * @covers \App\Models\Crew::socials
     */
    public function socials()
    {
        // when
        $this->crew->socials()->saveMany(factory(CrewSocial::class, 3)->create());

        // then
        $this->assertCount(3, $this->crew->socials);
    }

    /**
     * @test
     * @covers \App\Models\Crew::applyFor
     */
    public function applyFor()
    {
        // given
        $position     = factory(Position::class)->create();
        $crewPosition = factory(CrewPosition::class)->make()->toArray();

        // when
        $this->crew->applyFor(
            $position,
            Arr::only($crewPosition, ['details', 'union_description'])
        );

        // then
        $this->assertEquals(
            $position->name,
            $this->crew->positions->first()->name
        );
        $this->assertDatabaseHas('crew_position', [
            'crew_id'           => $this->crew->id,
            'position_id'       => $position->id,
            'details'           => $crewPosition['details'],
            'union_description' => $crewPosition['union_description'],
        ]);
    }

    /**
     * @test
     * @covers \App\Models\Crew::hasPosition
     */
    public function hasPosition()
    {
        // given
        $appliedPosition = factory(Position::class)->create();
        $randomPosition  = factory(Position::class)->create();

        // when
        $crewPosition = factory(CrewPosition::class)
            ->create([
                'crew_id'     => $this->crew->id,
                'position_id' => $appliedPosition->id,
            ]);

        // then
        $this->assertTrue($this->crew->hasPosition($appliedPosition));
        $this->assertFalse($this->crew->hasPosition($randomPosition));
    }

    /**
     * @test
     * @covers \App\Models\Crew::projects
     */
    public function projects()
    {
        // when
        $project = factory(Project::class, 3)->create()->each(function ($project) {
            $this->crew->projects()->attach($project);
        });

        // then
        $this->assertCount(3, $this->crew->projects);
    }

    /**
     * @test
     * @covers  \App\Models\Crew::getPhotoUrlAttribute
     */
    public function get_photo_url_attribute()
    {
        $crew  = factory(Crew::class)->create();
        $photo = UploadedFile::fake()
            ->image('photo.png');

        $crew->photo_path =
            $crew->hash_id . '/' .
            'photos' . '/' .
            $photo->hashName();

        $this->assertEquals(
            config('filesystems.disks.s3.url') . '/' .
            config('filesystems.disks.s3.bucket') . '/' .
            $crew->hash_id . '/' .
            'photos' . '/' .
            $photo->hashName(),
            $crew->photo_url
        );
    }
}
