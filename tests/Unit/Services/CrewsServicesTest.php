<?php

namespace Tests\Unit\Services;

use App\Role;
use App\Services\AuthServices;
use App\Services\CrewsServices;
use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CrewsServicesTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @var \App\Services\CrewsServices
     */
    protected $service;

    public function setUp()
    {
        parent::setUp();

        $this->service = app(CrewsServices::class);
    }

    /** @test */
    public function process_create()
    {
        Storage::fake();

        $user = factory(User::class)->create();

        $data = [
            'bio'    => 'some bio',
            'photo'  => UploadedFile::fake()->image('photo.png'),
            'resume' => UploadedFile::fake()->create('resume.pdf'),
        ];

        $crew = $this->service->processCreate($data, $user);

        $this->assertEquals($data['bio'], $crew->bio);

        $resume = $crew->resumes()->first();

        Storage::assertExists($crew->photo);
        Storage::assertExists($resume->url);
    }

    /** @test */
    public function create()
    {
        Storage::fake();

        $user = factory(User::class)->create();
        $data = [
            'user_id' => $user->id,
            'bio' => 'some bio',
            'photo' => UploadedFile::fake()->image('photo.png'),
            'photo_dir' => $user->uiid
        ];

        $crew = $this->service->create($data);

        $this->assertDatabaseHas('crews', [
            'id'      => $crew->id,
            'user_id' => $data['user_id'],
            'bio'     => $data['bio'],
            'photo'   => 'photos/' . $data['photo_dir'] .  '/' . $data['photo']->hashName()
        ]);

        Storage::assertExists($crew->photo);
    }

    /** @test */
    public function create_general_resume()
    {
        Storage::fake();

        $user = factory(User::class)->create();
        $crew = $this->service->create([
            'user_id'   => $user->id,
            'bio'       => 'some bio',
            'photo'     => UploadedFile::fake()->image('photo.png'),
            'photo_dir' => $user->uiid,
        ]);
        $data = [
            'crew_id'    => $crew->id,
            'resume_dir' => $user->uuid,
            'resume'     => UploadedFile::fake()->create('resume.pdf'),
        ];

        $resume = $this->service->createGeneralResume($data);

        $this->assertDatabaseHas('crew_resumes', [
            'id'      => $resume->id,
            'crew_id' => $user->id,
            'url'     => 'resumes/' . $data['resume_dir'] .  '/' . $data['resume']->hashName(),
            'general' => 1
        ]);

        Storage::assertExists($resume->url);
    }
}
