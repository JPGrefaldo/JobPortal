<?php

namespace Tests\Unit\Actions\Crew;

use App\Actions\Crew\SaveCrew;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SaveCrewTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @covers \App\Actions\Crew\SaveCrew::execute
     */
    public function execute()
    {
        // given
        Storage::fake('s3');

        $user = $this->createUser();
        $photo = UploadedFile::fake()->image('photo.png');
        $data = [
            'photo' => $photo,
            'bio'   => 'some bio',
        ];

        // when
        app(SaveCrew::class)->execute($user, $data);


        // then
        $this->assertDatabaseHas('crews', [
            'user_id'    => $user->id,
            'bio'        => 'some bio',
            'photo_path' => $user->hash_id . '/photos/' . $data['photo']->hashName(),
        ]);

        Storage::disk('s3')->assertExists($user->crew->photo);
    }
}
