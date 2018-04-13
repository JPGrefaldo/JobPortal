<?php

namespace Tests\Feature;

use App\Crew;
use App\Role;
use App\Services\AuthServices;
use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CrewsFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /** @test */
    public function create()
    {
        Storage::fake();

        $user = factory(User::class)->create();
        app(AuthServices::class)->createByRoleName(
            Role::CREW,
            $user,
            $this->getCurrentSite()
        );

        $photo = UploadedFile::fake()->image('photo.png');
        $resume = UploadedFile::fake()->create('resume.pdf');

        $data = [
            'bio' => 'some bio',
            'photo' => $photo,
            'resume' => $resume
        ];

        $response = $this->actingAs($user)->post('crews/create', $data);

        $response->assertSuccessful();

        $crew = Crew::where('user_id', $user->id)->first();

        $this->assertInstanceof(Crew::class, $crew);

        $this->assertEquals('some bio', $crew->bio);
        $this->assertEquals(
            'photos/' . $user->uuid .  '/' . $photo->hashName(),
            $crew->photo
        );
        $this->assertEquals(
            'resumes/' . $user->uuid.  '/' . $resume->hashName(),
            $crew->resumes->first()->url
        );

        Storage::assertExists($crew->photo);
        Storage::assertExists($crew->resumes->first()->url);
    }
}
