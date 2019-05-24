<?php

namespace Tests\Unit\Actions\Crew;

use App\Actions\Crew\UpdateCrew;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\Support\CreatesCrewModel;
use Tests\Support\Data\SocialLinkTypeID;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class UpdateCrewTest extends TestCase
{
    use RefreshDatabase,
        SeedDatabaseAfterRefresh,
        CreatesCrewModel;

    /**
     * @var array
     */
    public $models;

    public function setUp(): void
    {
        parent::setup();

        Storage::fake('s3');

        $this->models = $this->createCompleteCrew();
    }
    /**
     * @test
     * @covers \App\Actions\Crew\UpdateCrew::execute
     */
    public function execute()
    {
        // given
        $data = $this->getUpdateCrewData();

        // when
        app(UpdateCrew::class)->execute($this->models['crew'], $data);

        // then
        $editCrewMock = \Mockery::mock(EditCrew::class);
        $editCrewMock->shouldReceive('execute');

        $editCrewResume = \Mockery::mock(EditCrewResume::class);
        $editCrewResume->shouldReceive('execute');

        $editCrewReel = \Mockery::mock(EditCrewReel::class);
        $editCrewReel->shouldReceive('execute');

        $editCrewSocials = \Mockery::mock(EditCrewSocials::class);
        $editCrewSocials->shouldReceive('execute');
    }

    /**
     * @test
     * @covers \App\Actions\Crew\UpdateCrew::execute
     */
    public function socials_can_be_deleted()
    {
        // given
        $data = $this->getUpdateCrewData([
            'socials' => [
                'youtube' => [
                    'url' => '',
                ],
                'personal_website' => [
                    'url' => '',
                ],
            ],
        ]);

        // when
        app(UpdateCrew::class)->execute($this->models['crew'], $data);

        // then
        $this->assertCount(6, $this->models['crew']->socials);
        $this->assertDatabaseHas('crew_socials', [
            'crew_id'             => $this->models['crew']->id,
            'social_link_type_id' => SocialLinkTypeID::FACEBOOK,
            'url'                 => 'https://www.facebook.com/new-castingcallsamerica/',
        ]);

        $this->assertDatabaseHas('crew_socials', [
            'crew_id'             => $this->models['crew']->id,
            'social_link_type_id' => SocialLinkTypeID::TWITTER,
            'url'                 => 'https://twitter.com/new-casting_america',
        ]);


        $this->assertDatabaseHas('crew_socials', [
            'crew_id'             => $this->models['crew']->id,
            'social_link_type_id' => SocialLinkTypeID::IMDB,
            'url'                 => 'http://www.imdb.com/name/nm0000134/-updated',
        ]);

        $this->assertDatabaseHas('crew_socials', [
            'crew_id'             => $this->models['crew']->id,
            'social_link_type_id' => SocialLinkTypeID::TUMBLR,
            'url'                 => 'http://new-updated.tumblr.com',
        ]);

        $this->assertDatabaseHas('crew_socials', [
            'crew_id'             => $this->models['crew']->id,
            'social_link_type_id' => SocialLinkTypeID::VIMEO,
            'url'                 => 'https://player.vimeo.com/video/327999826',
        ]);

        $this->assertDatabaseHas('crew_socials', [
            'crew_id'             => $this->models['crew']->id,
            'social_link_type_id' => SocialLinkTypeID::INSTAGRAM,
            'url'                 => 'https://www.instagram.com/new-castingamerica/',
        ]);
    }

    /**
     * @test
     * @covers \App\Actions\Crew\UpdateCrew::execute
     */
    public function youtube_is_formatted_before_updated()
    {
        // given
        $data = $this->getUpdateCrewData([
            'reel_link'           => 'https://www.youtube.com/watch?v=2-_rLbU6zJo',
            'socials'             => [
                'youtube' => [
                    'url' => 'https://www.youtube.com/watch?v=G8S81CEBdNs',
                ],
            ],
        ]);

        // when
        app(UpdateCrew::class)->execute($this->models['crew'], $data);

        // then
        $this->assertDatabaseHas('crew_reels', [
            'crew_id'          => $this->models['crew']->id,
            'path'             => 'https://www.youtube.com/embed/2-_rLbU6zJo',
            'general'          => true,
            'crew_position_id' => null,
        ]);

        $this->assertDatabaseHas('crew_socials', [
            'crew_id'             => $this->models['crew']->id,
            'social_link_type_id' => SocialLinkTypeID::YOUTUBE,
            'url'                 => 'https://www.youtube.com/embed/G8S81CEBdNs',
        ]);
    }

    /**
     * @test
     * @covers \App\Actions\Crew\UpdateCrew::execute
     */
    public function vimeo_is_formatted_before_updated()
    {
        // given
        $data = $this->getUpdateCrewData([
            'socials' => [
                'vimeo' => [
                    'url' => 'https://vimeo.com/230046783',
                ],
            ],
        ]);

        // when
        app(UpdateCrew::class)->execute($this->models['crew'], $data);

        // then
        $this->assertDatabaseHas('crew_socials', [
            'crew_id'             => $this->models['crew']->id,
            'social_link_type_id' => SocialLinkTypeID::VIMEO,
            'url'                 => 'https://player.vimeo.com/video/230046783',
        ]);
    }
}
