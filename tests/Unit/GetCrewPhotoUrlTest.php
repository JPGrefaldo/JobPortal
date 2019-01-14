<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Crew;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Support\Data\SocialLinkTypeID;
use Tests\Support\SeedDatabaseAfterRefresh;

class GetCrewPhotoUrlTest extends TestCase
{
    use RefreshDatabase,
        SeedDatabaseAfterRefresh;
    /**
     * @test
     * @covers  \App\Models\Crew::getPhotoUrlAttribute
     */
    public function get_photo_url_attribute()
    {
        Storage::fake();

        $user = $this->createCrew();
        $data = $this->getUploadData();


        $this->assertEquals(config('disks.s3.url') . '/' . config('disks.s3.bucket') .  $user->hash_id . '/' . 'photo' . '/' . $data['photo']->hashName(),
            $user->photo_url);
    }

    public function getUploadData($customData = [])
    {
        $data = [
            'photo'   => UploadedFile::fake()
                ->image('photo.png'),
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
            array_set($data, $key, $value);
        }

        return $data;
    }
}
