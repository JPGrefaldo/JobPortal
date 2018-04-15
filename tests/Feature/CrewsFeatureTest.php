<?php

namespace Tests\Feature;

use App\Models\Crew;
use App\Models\Role;
use App\Services\AuthServices;
use App\Models\User;
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

        $data = [
            'bio'    => 'some bio',
            'photo'  => UploadedFile::fake()->image('photo.png'),
            'resume' => UploadedFile::fake()->create('resume.pdf'),
        ];

        $response = $this->actingAs($user)->post('crews/create', $data);

        $response->assertSuccessful();

        $crew = Crew::where('user_id', $user->id)->first();

        $this->assertEquals($data['bio'], $crew->bio);

        $resume = $crew->resumes->first();

        Storage::assertExists($crew->photo);
        Storage::assertExists($crew->resumes->first()->url);
    }
}
